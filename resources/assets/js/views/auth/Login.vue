<template>
  <span>Login</span>
</template>

<script>
  export default {
    activated () {
      this.$store.dispatch('templateSetTitle', 'Авторизація')
    },
  }
</script>
