<template>
  <div class="container">
      <div class="row">
          <div class="col">
              <div v-if="!onLive">
                  <button class="btn btn-success" @click="startStream">
                      Demarrer en direct
                  </button><br />
              </div>
              <div v-if="onLive">
                  <button type="button" class="btn btn-danger mx-4" @click="stopStream">Arrêter en direct</button>
                  <button type="button" class="btn btn-info" @click="toggleMuteAudio">
                      {{ mutedAudio ? "Unmute" : "Mute" }}
                  </button>
                  <button type="button" class="btn btn-primary" @click="toggleMuteVideo">
                      {{ mutedVideo ? "ShowVideo" : "HideVideo" }}
                  </button>
                  <button type="button" class="btn btn-warning" @click="screenShare">
                      {{ shareScreen ? "Caméra" : "Ecran" }}
                  </button>
              </div>
              <p v-if="isVisibleLink">Lien de partage: {{ streamLink }}</p>
          </div>
      </div>
    <div class="row">
      <div class="col-md-8">
          <canvas id="canvas" width="000" height="150"></canvas>
        <video autoplay ref="broadcaster" playsinline></video>
      </div>
        <div class="col-md-4">
            <p>Online users:</p>
            <ul class="list-group" v-for="user in streamingUsers">
                <li class="list-group-item"><strong class="text-success">O</strong> {{ user.name }}</li>
            </ul>
        </div>
    </div>
  </div>
</template>

<script>
import Peer from "simple-peer";
import { getPermissions } from "../helpers";
export default {
  name: "Broadcaster",
  props: [
    "auth_user_id",
    "env",
    "turn_url",
    "turn_username",
    "turn_credential",
  ],
  data() {
    return {
        onLive: false,
        stream: null,
        mutedAudio: false,
        mutedVideo: false,
        shareScreen: false,
      isVisibleLink: false,
      streamingPresenceChannel: null,
      streamingUsers: [],
      currentlyContactedUser: null,
      allPeers: {}, // this will hold all dynamically created peers using the 'ID' of users who just joined as keys
    };
  },

  computed: {
    streamId() {
      // you can improve streamId generation code. As long as we include the
      // broadcaster's user id, we are assured of getting unique streamiing link everytime.
      // the current code just generates a fixed streaming link for a particular user.
      return `${this.auth_user_id}12acde2`;
    },

    streamLink() {
      // just a quick fix. can be improved by setting the app_url
      if (this.env === "production") {
        return `https://laravel-video-call.herokuapp.com/streaming/${this.streamId}`;
      } else {
        return `https://localhost/laravel-video-chat/public/streaming/${this.streamId}`;
      }
    },
  },

  methods: {
    async startStream() {
      // const stream = await navigator.mediaDevices.getUserMedia({
      //   video: true,
      //   audio: true,
      // });
      // microphone and camera permissions
      const stream = await getPermissions(this.shareScreen);
      this.$refs.broadcaster.srcObject = stream;

      this.initializeStreamingChannel();
      this.initializeSignalAnswerChannel(); // a private channel where the broadcaster listens to incoming signalling answer
      this.isVisibleLink = true;
      this.onLive = true;
    },
      toggleMuteAudio() {
          if (this.mutedAudio) {
              this.$refs.broadcaster.srcObject.getAudioTracks()[0].enabled = true;
              this.mutedAudio = false;
          } else {
              this.$refs.broadcaster.srcObject.getAudioTracks()[0].enabled = false;
              this.mutedAudio = true;
          }
      },

      toggleMuteVideo() {
          if (this.mutedVideo) {
              this.$refs.broadcaster.srcObject.getVideoTracks()[0].enabled = true;
              this.mutedVideo = false;
          } else {
              this.$refs.broadcaster.srcObject.getVideoTracks()[0].enabled = false;
              this.mutedVideo = true;
          }
      },
      screenShare() {
        if (this.shareScreen) {
            this.shareScreen = false;
        } else {
            this.shareScreen = true;
        }
      },
      stopStream() {
        const videoElem = this.$refs.broadcaster;
        const streamVideo = videoElem.srcObject;
        const tracks = streamVideo.getTracks();
        tracks.forEach((track) => {
            track.stop();
        })
        videoElem.srcObject = null;
        this.onLive = false;
      },

    peerCreator(stream, user, signalCallback) {
      let peer;
      return {
        create: () => {
          peer = new Peer({
            initiator: true,
            trickle: false,
            stream: stream,
            config: {
              iceServers: [
                {
                  urls: "stun:stun.zilwa.fr:5349",
                },
                {
                  urls: this.turn_url,
                  username: this.turn_username,
                  credential: this.turn_credential,
                },
              ],
            },
          });
        },

        getPeer: () => peer,

        initEvents: () => {
          peer.on("signal", (data) => {
            // send offer over here.
            signalCallback(data, user);
          });

          peer.on("stream", (stream) => {
            console.log("onStream");
          });

          peer.on("track", (track, stream) => {
            console.log("onTrack");
          });

          peer.on("connect", () => {
            console.log("Broadcaster Peer connected");
          });

          peer.on("close", () => {
            console.log("Broadcaster Peer closed");
          });

          peer.on("error", (err) => {
            console.log("handle error gracefully");
          });
        },
      };
    },

    initializeStreamingChannel() {
      this.streamingPresenceChannel = window.Echo.join(
        `streaming-channel.${this.streamId}`
      );

      this.streamingPresenceChannel.here((users) => {
        this.streamingUsers = users;
      });

      this.streamingPresenceChannel.joining((user) => {
        console.log("New User", user);
        // if this new user is not already on the call, send your stream offer
        const joiningUserIndex = this.streamingUsers.findIndex(
          (data) => data.id === user.id
        );
        if (joiningUserIndex < 0) {
          this.streamingUsers.push(user);

          // A new user just joined the channel so signal that user
          this.currentlyContactedUser = user.id;

          this.$set(
            this.allPeers,
            `${user.id}`,
            this.peerCreator(
              this.$refs.broadcaster.srcObject,
              user,
              this.signalCallback
            )
          );
          // Create Peer
          this.allPeers[user.id].create();

          // Initialize Events
          this.allPeers[user.id].initEvents();
        }
      });

      this.streamingPresenceChannel.leaving((user) => {
        console.log(user.name, "Left");
        // destroy peer
        this.allPeers[user.id].getPeer().destroy();

        // delete peer object
        delete this.allPeers[user.id];

        // if one leaving is the broadcaster set streamingUsers to empty array
        if (user.id === this.auth_user_id) {
          this.streamingUsers = [];
        } else {
          // remove from streamingUsers array
          const leavingUserIndex = this.streamingUsers.findIndex(
            (data) => data.id === user.id
          );
          this.streamingUsers.splice(leavingUserIndex, 1);
        }
      });
    },

    initializeSignalAnswerChannel() {
      window.Echo.private(`stream-signal-channel.${this.auth_user_id}`).listen(
        "StreamAnswer",
        ({ data }) => {
          console.log("Signal Answer from private channel");

          if (data.answer.renegotiate) {
            console.log("renegotating");
          }
          if (data.answer.sdp) {
            const updatedSignal = {
              ...data.answer,
              sdp: `${data.answer.sdp}\n`,
            };

            this.allPeers[this.currentlyContactedUser]
              .getPeer()
              .signal(updatedSignal);
          }
        }
      );
    },

    signalCallback(offer, user) {
      axios
        .post("https://localhost/laravel-video-chat/public/stream-offer", {
          broadcaster: this.auth_user_id,
          receiver: user,
          offer,
        })
        .then((res) => {
          console.log(res);
        })
        .catch((err) => {
          console.log(err);
        });
    },
  },
};
</script>

<style scoped>
</style>
