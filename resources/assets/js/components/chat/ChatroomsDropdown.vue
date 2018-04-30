<template>
    <div class="input-group">
	<span class="input-group-addon">
        Current Chatroom:
    </span>
        <select id='currentChatroom'
                v-model="selected"
                class="form-control"
                @change='changedRoom()'>

            <option v-for="chatroom in chatrooms" :value='chatroom'>{{ chatroom }}</option>
        </select>
    </div>
</template>

<style scoped>
    .input-group .input-group-addon {
        background-color: transparent;
        border: none;
    }
</style>

<script>
  export default {
    data () {
      return {
        selected: ''
      }
    },
    computed: {
      chatrooms () {
        return this.$parent.chatrooms
      }
    },
    methods: {
      changedRoom () {
        this.$emit('changedRoom', this.selected)
      }
    }
  }
</script>