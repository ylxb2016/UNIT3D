<template>
    <tr class="forum-component">
        <td class="text-center">
            <img src="/img/forum.png" class="img-responsive">
        </td>
        <td>
            <h4>
                <a href="">
                    <span class="text-bold">{{ forum.name }}</span>
                </a>
            </h4>

            {{ forum.description }}
        </td>
        <td class="text-center">{{ forum.posts_count }}</td>
        <td class="text-center">{{ forum.topics_count }}</td>
        <td>
            Last Message - author
            <i class="fa fa-user"></i>

            <a href="">
                {{ forum.last_post_username }}
            </a>

            <br>

            Topic <i class="fa fa-chevron-right"></i>

            <a href="">
                {{ forum.last_topic_name }}
            </a>

            <br>

            <i class="fa fa-clock-o"></i> {{ forum.created_at }}
        </td>
    </tr>
</template>
<script>
  export default {
    name: 'forum',
    props: {
      forum: {required: true}
    }
  }
</script>
<style lang="scss" scoped>
    .forum-component {
        img {
            display: inline-block
        }
    }
</style>