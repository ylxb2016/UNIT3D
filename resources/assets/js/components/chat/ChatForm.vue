<template>
    <div class="message-input">
        <div class="wrap">

            <textarea v-model="newMessage"
                      @keyup.enter="sendMessage"
                      id="chat-message"
                      name="message"
                      placeholder="Write your message..."
                      cols="30"
                      rows="2">

            </textarea>

            <!--<input id="btn-input"
                   type="text"
                   name="message"
                   class="form-control"
                   placeholder="Write your message..."
                   v-model="newMessage"
                   @keyup.enter="sendMessage">-->

            <!--<button class="submit" id="btn-chat" @click="sendMessage">
                <i class="fa fa-paper-plane" aria-hidden="true"></i>
            </button>-->
        </div>
    </div>
</template>

<script>
  export default {

    props: ['user'],

    data () {
      return {
        editor: null,
        newMessage: null
      }
    },

    methods: {
      sendMessage () {

        if (this.newMessage !== null) {
          this.$emit('message-sent', {
            user: this.user,
            message: this.newMessage
          })

          this.newMessage = null
        }

      }
    },

    mounted () {
      this.editor = $('#chat-message').wysibb()
    }
  }
</script>

<style lang="scss" scoped>
    .message-input {
        input {
            margin-left: 10px;
        }
    }
</style>