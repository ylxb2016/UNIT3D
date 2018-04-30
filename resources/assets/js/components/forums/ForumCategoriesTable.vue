<template>
    <div class="forum-categories">
        <forum-category v-for="category in categories" :key="category.id" :name="category.name">

            <table class="table table-bordered table-hover table-responsive">
                <thead class="head">
                <tr>
                    <td></td>
                    <td>Name</td>
                    <td>Posts</td>
                    <td>Topics</td>
                    <td>Latest</td>
                </tr>
                </thead>
                <tbody>

                <forum v-for="forum in category.forums" :key="forum.id" :forum="forum"></forum>

                </tbody>
            </table>

        </forum-category>
    </div>
</template>

<script>
  import ForumCategory from './ForumCategory'
  import Forum from './Forum'

  export default {
    name: 'forum-categories-table',
    props: {
      categories: {required: true}
    },
    components: {
      ForumCategory,
      Forum
    }
  }
</script>