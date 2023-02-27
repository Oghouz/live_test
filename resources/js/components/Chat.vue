<template>
    <div class="chat">
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    <div class="row">
                        <div class="col">
                            <i class="fa fa-message"></i> Chat
                        </div>
                        <div class="col text-end">
                            <button class="btn btn-sm" @click="enableNotificationSound">
                                <i v-if="notificationSoundEnable" class="fa fa-volume-high"></i>
                                <i v-else class="fa fa-volume-xmark"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="chat-messages" id="chat-messages">
                    <div class="chat-box" v-for="msg in messages">
                        <span class="chat-box-user">{{ msg.name }}: </span>
                        <p class="chat-box-message ps-1">{{ msg.message }}</p>
                    </div>
                </div>
            </div>
            <div class="card-footer text-right">
                <textarea v-model="text" class="form-control"></textarea>
                <button type="button" class="btn btn-sm btn-success" @click="sendMessage"><i class="fa fa-message"></i> Envoyer</button>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    name: 'chat',
    props: ['auth_user', 'live_id', 'is_admin'],
    data() {
        return {
            notificationSound: null,
            notificationSoundEnable: true,
            currentUser: null,
            text: '',
            messages: [],
            home_url: 'https://localhost/live_test/public/',

        }
    },
    mounted() {
        this.notificationSound = new Audio("https://localhost/live_test/public/sounds/notification.mp3")
        window.Echo.private('chat')
        .listen('ChatEvent', (e) => {
            console.log("chatEvent response: ", e)
            this.messages.push({
                name: e.user.name,
                message: e.message
            })
        })
        this.initializeMessages()
    },
    methods: {
        sendMessage() {
            this.messages.push({
                'name': this.username,
                'message': this.text
            })
            const box = document.getElementById('chat-messages')
            box.scrollTop = box.scrollHeight
            if (this.notificationSoundEnable) {
                this.notificationSound.play();
            }
            // this.$emit('chatevent', {
            //     user: this.auth_user.name,
            //     message: this.text
            // })

            axios.post(this.chatUrl+'messages', {
                live_id: this.live_id,
                user_id: this.userId,
                username: this.username,
                message: this.text,
            })
            .then((response) => {
                console.log("axios post response: ", response)
                console.log("this.text: ", this.text)
            })
            this.text = '';

        },
        async initializeMessages() {
            axios.post(this.chatUrl + 'get/messages', {
                live_id: this.live_id,
                user_id: this.userId
            })
            .then((response) => {
                response.data.forEach((item, index) => {
                    this.messages.push({
                        name: item.sender,
                        message: item.message
                    })
                })
            })
        },
        enableNotificationSound() {
            this.notificationSoundEnable = !this.notificationSoundEnable
        }
    },
    computed: {
        chatUrl() {
          if (this.is_admin) {
              return this.home_url + 'dashboard/chat/'
          } else {
              return this.home_url + 'chat/'
          }
        },
        username() {
            return JSON.parse(this.auth_user).name
        },
        userId() {
            return JSON.parse(this.auth_user).id
        }
    }
}

</script>

<style scoped>
.chat {
    height: 100%;
}
.chat-messages {
    overflow-y: scroll;
    height: 100%;
}
.chat-box {
    background-color: #f6f6f6;
    padding: 5px 10px;
    border-radius: 10px;
    font-size: 12px;
    margin: 10px;
}
.chat-box-user {
    font-size: 11px;
    font-weight: bold;
    padding-bottom: 0 !important;
}
.chat-box-message {
    padding: 0;
}
.chat-box-time {

}
</style>
