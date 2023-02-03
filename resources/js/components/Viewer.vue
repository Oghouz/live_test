<template>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-8">
          <span class="badge bg-success" v-if="liveStarted">Le live est commerncer</span>
<!--          <span class="badge bg-secondary" v-else>Pas de live pour le moment.</span>-->
          <br>
        <button class="btn btn-success" @click="joinBroadcast" :disabled="loading" v-show="!participated">
            <i v-if="!loading" class="fa fa-video"></i>
            <i v-else class="fa fa-spinner fa-spin"></i>
            {{ loading ? "Préparation en cours..." : "Rejoint en direct"}}
        </button>
        <button class="btn btn-danger" v-show="participated" @click="removeBroadcastVideo">
            <i class="fa fa-video"></i> Quitter en direct
        </button>
          <button class="btn btn-info" v-show="participated" @click="fullScreen">
              <i class="fa fa-th"></i>
              Plain écran
          </button>
      </div>
    </div>
      <div class="row mt-2">
          <div class="col-8">
              <div class="card">
                  <div class="card-body">
                      <video autoplay id="viewer" ref="viewer" style="width: 100%"></video>
                  </div>
              </div>
          </div>
          <div class="col-4">
              <chat v-if="participated" :auth_user="auth_user" :live_id="stream_id" :is_admin="false"></chat>
          </div>
      </div>
  </div>
</template>

<script>
import Peer from "simple-peer";
export default {
  name: "Viewer",
  props: [
      "home_url",
      "auth_user",
      "auth_user_id",
      "stream_id",
      "turn_url",
      "turn_username",
      "turn_credential",
  ],
  data() {
    return {
      loading: false,
      liveStarted: false,
      participated: false,
      streamingPresenceChannel: null,
      broadcasterPeer: null,
      broadcasterId: null,
    };
  },
    methods: {
        joinBroadcast() {
          this.loading = true;
          this.initializeStreamingChannel();
          this.initializeSignalOfferChannel(); // a private channel where the viewer listens to incoming signalling offer
        },
        initializeStreamingChannel() {
          this.streamingPresenceChannel = window.Echo.join(
            `streaming-channel.${this.stream_id}`
          );
        },
        createViewerPeer(incomingOffer, broadcaster) {
          const peer = new Peer({
            initiator: false,
            trickle: false,
            config: {
              iceServers: [
                {
                    urls: "stun:stun.zilwa.fr",
                },
                {
                  urls: this.turn_url,
                  username: this.turn_username,
                  credential: this.turn_credential,
                },
              ],
            },
          });

          // Add Transceivers
          peer.addTransceiver("video", { direction: "recvonly" });
          peer.addTransceiver("audio", { direction: "recvonly" });

          // Initialize Peer events for connection to remote peer
          this.handlePeerEvents(
            peer,
            incomingOffer,
            broadcaster,
            this.removeBroadcastVideo
          );

          this.broadcasterPeer = peer;
        },
        handlePeerEvents(peer, incomingOffer, broadcaster, cleanupCallback) {
          peer.on("signal", (data) => {
              console.log("peer on signal")
            axios
              .post(this.home_url + "/stream-answer", {
                broadcaster,
                answer: data,
              })
              .then((res) => {
                console.log("response", res);
              })
              .catch((err) => {
                console.log("error", err);
              });
          });

          peer.on("stream", (stream) => {
            // display remote stream
              console.log("peer on stream", stream)
              this.$refs.viewer.srcObject = stream;
          });

          peer.on("track", (track, stream) => {
            console.log("peer on track");
          });

          peer.on("connect", () => {
            console.log("peer on connect");
          });

          peer.on("close", () => {
            console.log("peer on close");
            peer.destroy();
            cleanupCallback();
          });

          peer.on("error", (err) => {
              console.log(err)
            console.log("peer on error");
          });

          const updatedOffer = {
            ...incomingOffer,
            sdp: `${incomingOffer.sdp}\n`,
          };
          peer.signal(updatedOffer);
        },
        initializeSignalOfferChannel() {
          window.Echo.private(`stream-signal-channel.${this.auth_user_id}`).listen(
            "StreamOffer",
            ({ data }) => {
              console.log("Signal Offer from private channel");
                console.log(data);
              this.broadcasterId = data.broadcaster;
              this.createViewerPeer(data.offer, data.broadcaster);
              this.loading = false;
              this.participated = true;
            }
          );
        },
        removeBroadcastVideo() {
          console.log("removingBroadcast Video");
          alert("La diffusion est terminée");
          const viewer = this.$refs.viewer;
            console.log(viewer)
          const tracks = this.$refs.viewer.srcObject.getTracks();

          tracks.forEach((track) => {
            track.stop();
          });
          this.$refs.viewer.srcObject = null;
          this.participated = false;
        },
        fullScreen() {
            document.getElementById('viewer').requestFullscreen();
        },
  },
};
</script>

<style scoped>

</style>
