<script>
  import {mapState} from 'vuex'
  import Pusher from 'pusher-js'
  export default {
    created () {
      this.pusher = new Pusher('a6b546201d500b404db7', {
        encrypted: true,
        cluster: 'mt1'
      })
      let that = this
      var context = { title: 'Pusher' }
      this.channel = this.pusher.subscribe('chat_channel')
      this.channel.bind('chat_saved', function (data) {
        that.$emit('incoming_chat', data)
      }, context)
      this.$on('incoming_chat', function (chatMessage) {
        this.incomingChat(chatMessage)
      })
    },
    computed: {
      ...mapState({
        chatStore: state => state.chatStore,
        userStore: state => state.userStore
      })
    },
    data () {
      return {
        message: null,
        pusher: null,
        channel: null
      }
    },
    methods: {
      handleAddChat () {
        if (this.message !== null) {
          this.$logger('info', 'handleAddChat')
          let postData = {
            'receiver_id': this.chatStore.currentChatUser.id,
            'chat': this.message
          }
          this.$store.dispatch('addNewChatToConversation', postData)
            .then(response => {
              this.message = null
              let element = document.getElementById('chat-widget-wrapper')
              element.scrollIntoView(false)
            })
        }
      },
      incomingChat (chatMessage) {
        // Attention !!! chatMessage.message.sender_id est un string! Il est nécessaire de le convertir en int
        var senderId = parseInt(chatMessage.message.sender_id)
        if (this.chatStore.currentChatUser.id === senderId) {
          if (chatMessage.message.receiver.email === this.userStore.authUser.email) {
            this.$store.dispatch('newIncomingChat', chatMessage.message)
                    .then(res => {
                      let element = document.getElementById('chat-widget-wrapper')
                      element.scrollIntoView(false)
                    })
          } else {
          }
        }
      }
    }
  }
</script>


<template>
  <div id="chat-add-widget" v-if="chatStore.currentChatUser != null">
    <form v-on:submit.prevent="handleAddChat()">
      <div class="form-group">
        <input
          type="text"
          class="form-control"
          placeholder="Type your text"
          v-model="message"
        >

      </div>
    </form>
  </div>
</template>

<style lang="scss">
  #chat-add-widget {
    position: fixed;
    bottom: 0;
    width: 80%;
  }
</style>
