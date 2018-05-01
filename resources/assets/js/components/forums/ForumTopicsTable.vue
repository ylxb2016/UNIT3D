<template>
    <div class="forum-topics-table">
        <table class="f-display-topics table col-md-12">
            <thead>
            <tr>
                <th></th>
                <th>Topic</th>
                <th>Author</th>
                <th>Stats</th>
                <th>Latest Post Info</th>
            </tr>
            </thead>
            <tbody>
                <forum-topic v-for="topic in topics" :topic="topic"></forum-topic>
            </tbody>
        </table>
    </div>
</template>

<script>
  import ForumTopic from './ForumTopic'

  export default {
    name: 'forum-topics-table',
    props: {
      topics: {required: true}
    },
    components: {
      ForumTopic
    }
  }
</script>