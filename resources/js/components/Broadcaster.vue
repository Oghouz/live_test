<template>
    <div>
        <div class="row mb-4 ms-2">
            <div class="col-8">
                <div v-if="!onLive">
                    <button class="btn btn-success btn-xl" @click="startStream" :disabled="loading">
                        <i v-if="!loading" class="ti-video-camera"></i>
                        <i v-else class="fa fa-spinner fa-spin"></i>
                        {{ loading ? " Préparation en cours..." : " Demarrer en direct"}}
                    </button><br />
                </div>
                <div v-if="onLive">
                    <button type="button" class="btn btn-social-icon-text btn-youtube" @click="stopStream">
                        <i class="mdi mdi-stop"></i>
                        Arrêter en direct
                    </button>
                    <button type="button" class="btn btn-social-icon-text btn-facebook" @click="toggleMuteAudio">
                        <i class="mdi" :class="mutedAudio ? ' mdi-microphone-off' : 'mdi-microphone' "></i>
                        {{ mutedAudio ? "Unmuted" : "Muted" }}
                    </button>
                    <button type="button" class="btn btn-social-icon-text btn-facebook" @click="toggleMuteVideo">
                        <i class="mdi" :class="mutedVideo ? 'mdi-camcorder-off' : 'mdi-camcorder' "></i>
                        {{ mutedVideo ? "ShowVideo" : "HideVideo" }}
                    </button>
                    <button type="button" class="btn btn-social-icon-text btn-facebook" @click="shareScreen">
                        <i class="mdi" :class="screenShared ? 'mdi-webcam' : 'mdi-monitor'"></i>
                        {{ screenShared ? "Camera" : "Ecran" }}
                    </button>
                </div>
            </div>
            <div class="col-4" v-if="onLive">
                <div class="display-3">
                    <i class="mdi mdi-timer"></i>
                    <label id="hors">{{ durationHors }}</label>
                    <label>:</label>
                    <label id="minutes">{{ durationMinute }}</label>
                    <label>:</label>
                    <label id="seconds">{{ durationSecond }}</label>
                </div>

            </div>
        </div>
        <div class="row">
            <div class="col">
                <p v-if="isVisibleLink">
                    <button type="button" class="btn btn-outline-facebook btn-social-icon-text">
                        <i class="ti-share"></i>
                        <span class="ps-1">{{ streamLink }}</span>
                    </button>
                </p>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-8">
                <div class="card">
                    <div class="card-body">
                        <video autoplay ref="broadcaster" playsinline width="640" height="480"></video>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="card">
                    <div class="card-body">
                        <p class="card-title small-text">Les participants:</p>
                        <ul class="list-group" v-for="user in streamingUsers">
                            <li class="list-group-item"><i class="mdi mdi-account"></i> {{ user.name }}</li>
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Peer from "simple-peer";
import { getPermissions } from "../helpers"
import MultiStreamsMixer  from "multistreamsmixer"

export default {
    name: "Broadcaster",
    props: [
        "home_url",
        "auth_user_id",
        "env",
        "turn_url",
        "turn_username",
        "turn_credential",
        "live_id",
    ],
    data() {
        return {
            peer : null,
            mixer: null,
            onLive: false,
            stream: null,
            cameraStream: null,
            screenStream: null,
            mutedAudio: false,
            audioMutedClass: "fa fa-microphone-slash",
            mutedVideo: false,
            screenShared: false,
            loading: false,
            isVisibleLink: false,
            streamingPresenceChannel: null,
            streamingUsers: [],
            currentlyContactedUser: null,
            allPeers: {}, // this will hold all dynamically created peers using the 'ID' of users who just joined as keys
            totalSeconds: 0,
            durationHors: '00',
            durationMinute: '00',
            durationSecond: '00'
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
            return `https://live.zilwa.fr/streaming/${this.streamId}`;
        },
    },
    methods: {
        async prepareStream() {
            this.cameraStream = await getPermissions(this.screenShared);
            this.mixer = new MultiStreamsMixer([this.cameraStream])

            this.mixer.frameInterval = 1;
            this.mixer.startDrawingFrames();

            this.stream = this.mixer.getMixedStream()
            this.$refs.broadcaster.srcObject = this.stream;
        },
        async startStream() {
            this.loading = true;
            await this.prepareStream();
            this.initializeStreamingChannel();
            this.initializeSignalAnswerChannel(); // a private channel where the broadcaster listens to incoming signalling answer
            this.isVisibleLink = true;
            this.onLive = true;
            this.loading = false;
            this.setLiveStartedTime();
            setInterval(this.setTime, 1000);
        },
        async shareScreen() {
            this.screenShared = !this.screenShared
            if (this.screenShared) {
                this.screenStream = await getPermissions(true);
                this.screenStream.fullcanvas = true;
                this.screenStream.width = screen.width;
                this.screenStream.height = screen.height;

                this.cameraStream.width = parseInt((20 / 100) * this.screenStream.width);
                this.cameraStream.height = parseInt((20 / 100) * this.screenStream.height);
                this.cameraStream.top = this.screenStream.height - this.cameraStream.height;
                this.cameraStream.left = this.screenStream.width - this.cameraStream.width;

                this.mixer.frameInterval = 1;
                this.mixer.startDrawingFrames();
                this.mixer.appendStreams([this.screenStream])

                console.log("screen shared")
            } else {
                //this.cameraStream.fullcanvas = true;
                this.cameraStream.width = screen.width;
                this.cameraStream.height = screen.height;
                this.cameraStream.top = 0
                this.cameraStream.left = 0

                this.mixer.frameInterval = 1;
                this.mixer.startDrawingFrames();
                this.mixer.resetVideoStreams([this.cameraStream])
                console.log("screen share canceled")
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
            this.setLiveEndedTime();
        },
        peerCreator(stream, user, signalCallback) {
            //let peer;
            return {
                create: () => {
                    this.peer = new Peer({
                        initiator: true,
                        trickle: false,
                        stream: stream,
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
                },

                getPeer: () => this.peer,

                initEvents: () => {
                    this.peer.on("signal", (data) => {
                        // send offer over here.
                        console.log("peer on signal")
                        signalCallback(data, user);
                    });

                    this.peer.on("stream", (stream) => {
                        console.log("peer on stream");
                    });

                    this.peer.on("track", (track, stream) => {
                        console.log("peer on track");
                    });

                    this.peer.on("connect", () => {
                        console.log("peer on connect");
                    });

                    this.peer.on("close", () => {
                        console.log("peer on close");
                    });

                    this.peer.on("error", (err) => {
                        console.log("peer on error");
                        console.log(err)
                    });
                },
            };
        },
        initializeStreamingChannel() {
            this.streamingPresenceChannel = window.Echo.join(
                `streaming-channel.${this.streamId}`
            );

            this.streamingPresenceChannel.here((users) => {
                console.log("users:", users)
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
                            this.stream,
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
                if(this.allPeers[user.id]) {
                    this.allPeers[user.id].getPeer().destroy();
                }

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
                    console.log(data)
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
                .post(this.home_url+"/stream-offer", {
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
        toggleMuteAudio() {
            if (this.mutedAudio) {
                this.$refs.broadcaster.srcObject.getAudioTracks()[0].enabled = true;
                this.mutedAudio = false;
                this.audioMutedClass = "fa fa-microphone-slash"
            } else {
                this.$refs.broadcaster.srcObject.getAudioTracks()[0].enabled = false;
                this.mutedAudio = true;
                this.audioMutedClass = "fa fa-microphone"
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
        setLiveStartedTime() {
          axios.post(this.home_url+'/dashboard/live/set/started', {
              live_id: this.live_id
          })
        },
        setLiveEndedTime() {
            axios.post(this.home_url+'/dashboard/live/set/ended', {
                live_id: this.live_id
            })
        },
        setTime() {
            ++this.totalSeconds;
            this.durationSecond = this.pad(this.totalSeconds%60)
            this.durationMinute = this.pad(parseInt(this.totalSeconds/60));
        },
        pad(val) {
            let valString = val + "";
            if(valString.length < 2) {
                return "0" + valString;
            } else {
                return valString;
            }
        },
    },
};
</script>
<style scoped>
video {
    width: 100%;
    height: auto;
}
</style>
