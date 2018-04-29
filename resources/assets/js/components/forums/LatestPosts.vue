<template>
    <div id="latest-posts">
        <div class="panel panel-chat">
            <div class="panel-heading">
                <h4>
                    Latest Posts
                </h4>
            </div>
            <div class="table-responsive">
                <table class="table table-condensed table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>Post</th>
                        <th>Topic</th>
                        <th>Author</th>
                        <th>Created</th>
                    </tr>
                    </thead>
                    <tbody>

                    <tr v-for="post in posts" v-if="canRead">
                        <td>
                            <a :href="`/topic/${post.slug}?page=1#post-${post.id}`">
                                {{ post.body }}
                            </a>
                        </td>
                        <td>
                            <a :href="`/topic/${post.topic.slug}`">
                                {{ post.topic.name }}
                            </a>
                        </td>
                        <td>{{ post.user.username }}</td>
                        <td>{{ post.updated_at }}</td>
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
    name: 'latest-posts',

    props: {
      canRead: {default: true}
    },

    data () {
      return {
        posts: []
      }
    },

    methods: {
      getPosts () {
        axios.get(`/api/forums/latest/posts`, {
          params: {
            limit: 5,
            strip: true
          }
        })
          .then((response) => {
            this.posts = response.data.data
          })
          .catch((error) => {
            console.error(error.response.message)
          })
      }
    },

    created () {
      this.getPosts()
    }
  }
</script>
<style>

</style>