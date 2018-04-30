<template>
    <div id="latest-topics">
        <div class="panel panel-chat">
            <div class="panel-heading">
                <h4>
                    Latest Topics
                </h4>
            </div>
            <div class="table-responsive">
                <table class="table table-condensed table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>Topic</th>
                        <th>Author</th>
                        <th>Created</th>
                    </tr>
                    </thead>
                    <tbody>

                    <tr v-for="topic in topics" v-if="canRead">
                        <td>
                            <a :href="`/topic/${topic.slug}`">
                                {{ topic.name }}
                            </a>
                        </td>
                        <td>{{ topic.user.username }}</td>
                        <td>{{ topic.created_at }}</td>
                    </tr>
                    <tr v-else>
                        <td>You don't have permission to view.</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>
<script>
  export default {
    name: 'latest-topics',

    props: {
      canRead: {default: true}
    },

    data () {
      return {
        topics: []
      }
    },

    methods: {
      getTopics () {
        axios.get(`/api/forums/latest/topics`)
          .then((response) => {
            this.topics = response.data.data
          })
          .catch((error) => {
            console.error(error.response.message)
          })
      }
    },

    created () {
      this.getTopics()
    }
  }
</script>
<style>

</style>