<template>
    <div class="col-md-10 col-sm-10 col-md-offset-1">
        <div class="clearfix visible-sm-block"></div>
        <div class="panel panel-chat">
            <div class="panel-heading">
                <h4>Chatbox</h4>
            </div>

            <div id="frame">
                <div id="sidepanel">
                    <div id="profile">
                        <div class="wrap">

                            <img :src="auth.image ? auth.image : '/img/profile.png'"
                                 @click="showStatuses = !showStatuses"
                                 :class="status.toLowerCase()"
                                 alt="">

                            <div v-if="showStatuses" class="statuses">
                                <ul class="list-unstyled">
                                    <li class="text-center" @click="statusChanged('Online')">
                                        <i class="fa fa-dot-circle-o text-green"></i>
                                    </li>
                                    <li class="text-center" @click="statusChanged('Away')">
                                        <i class="fa fa-dot-circle-o text-yellow"></i>
                                    </li>
                                    <li class="text-center" @click="statusChanged('Busy')">
                                        <i class="fa fa-dot-circle-o text-red"></i>
                                    </li>
                                    <li class="text-center" @click="statusChanged('Offline')">
                                        <i class="fa fa-dot-circle-o"></i>
                                    </li>
                                </ul>
                            </div>

                        </div>
                    </div>

                    <div id="bottom-bar">
                        <button id="channels"><i class="fa fa-cog fa-fw" aria-hidden="true"></i></button>
                    </div>
                </div>
                <div class="content">

                    <div class="contact-profile">
                        <chatrooms-dropdown :current="auth.chatroom.id"
                                            :chatrooms="chatrooms"
                                            @changedRoom="changeRoom">

                        </chatrooms-dropdown>
                    </div>

                    <chat-messages :messages="room.messages"></chat-messages>

                    <chat-form @message-sent="createMessage" :user="auth"></chat-form>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
  import ChatroomsDropdown from './ChatroomsDropdown'
  import ChatMessages from './ChatMessages'
  import ChatForm from './ChatForm'

  export default {
    props: {
      forceScoll: {type: Boolean, default: false},
      user: {
        type: Object,
        required: true,
      }
    },
    components: {
      ChatroomsDropdown,
      ChatMessages,
      ChatForm
    },
    data () {
      return {
        auth: {},
        status: 'Online',
        showStatuses: false,
        chatrooms: [],
        currentRoom: 1,
        room: {},
        scrolled: false
      }
    },
    computed: {},
    methods: {
      statusChanged (status) {
        this.status = status
        this.showStatuses = false
      },

      fetchRooms () {
        axios.get('/api/chat/rooms').then(response => {
          this.chatrooms = response.data
        })
      },

      changeRoom (id) {
        this.currentRoom = id
        this.room = {}

        axios.get(`/api/chat/room/${id}`).then(response => {
          this.room = response.data.data

          axios.put(`/api/chat/user/${this.auth.id}/chatroom`, {
            'room_id': this.currentRoom
          }).then(response => {
            this.auth = response.data
          })

        })

      },

      fetchMessages () {
        axios.get(`/api/chat/room/${this.currentRoom}/messages`)
          .then(response => {
            this.room.messages = _.orderBy(response.data.data, ['id'], ['asc'])
          })
      },

      createMessage (message) {
        this.room.messages.push(message)

        axios.post('/api/chat/messages', {
          'user_id': this.auth.id,
          'chatroom_id': this.currentRoom,
          'message': message.message
        })

      },
    },
    created () {
      this.auth = this.user

      this.fetchRooms()
      this.changeRoom(this.auth.chatroom.id)

      setInterval(() => {
        this.fetchMessages()

        let messages = $('.messages .list-group')

        messages.animate({scrollTop: messages.prop('scrollHeight')}, 0)

        messages.scroll(() => {
          this.forceScroll = false

          let scrollTop = messages.scrollTop() + messages.prop('clientHeight')
          let scrollHeight = messages.prop('scrollHeight')

          this.forceScroll = scrollTop >= scrollHeight
        })

      }, 3000)
    },
  }
</script>

<style lang="scss" scoped>
    .panel-chat {

        #profile .wrap {
            height: 60px;
            line-height: 60px;
            overflow: visible !important;

            .statuses {
                padding-top: 55px;
            }
        }

    }
</style>
