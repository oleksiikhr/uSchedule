<template>
  <span>Register</span>
</template>

<script>
  export default {
    data () {
      return {

      }
    },
    activated () {
      this.$store.dispatch('templateSetTitle', 'Реєстрація')
    }
  }
</script>
