<template>
    <div id="latest-topics">
        <div class="panel panel-chat shoutbox">
            <div class="panel-heading">
                <h4>
                    Latest Topics
                </h4>
            </div>
            <div class="table-responsive">
                <table class="table table-condensed table-striped table-bordered">
                    <thead>
                    <tr>
                        <th class="torrents-filename">Topic</th>
                        <th>Author</th>
                        <th>Created</th>
                    </tr>
                    </thead>
                    <tbody>

                    <tr v-for="topic in topics" v-if="topic.user.id === auth.id">
                        <td>
                            <a :href="`/topic/${topic.slug}`">
                                {{ topic.name }}
                            </a>
                        </td>
                        <td>{{ topic.user.username }}</td>
                        <td>{{ topic.created_at }}</td>
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

      props: ['topics'],

      data() {
        return {

        }
      },
    }
</script>
<style>

</style>