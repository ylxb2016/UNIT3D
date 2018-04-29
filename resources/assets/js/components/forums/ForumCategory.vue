<template>
    <div class="forum-category">
        <div class="header gradient teal">
            <div class="inner_content">
                <h1>{{ name }}</h1>
            </div>
        </div>

        <slot></slot>
    </div>
</template>

<script>
  export default {
    name: 'forum-category',
    props: {
      name: {required: true}
    }
  }
</script>