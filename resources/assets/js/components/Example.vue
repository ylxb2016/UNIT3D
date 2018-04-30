<template>
    <div class="container example-component">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header">{{ header }}</div>

                    <div class="card-body">
                        {{ message }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
  export default {
    name: 'example-component',

    data () {
      return {
        header: `Example Component`,
        message: `I'm an example component.`
      }
    },

    mounted () {
      console.log('Component mounted.')
    }
  }
</script>

<style lang="scss" scoped>
    .example-component {
        .card-header {
            color: #8c0000;
        }
    }
</style>