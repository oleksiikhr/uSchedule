<template>
  <v-container id="login" fluid>
    <v-layout column justify-center align-center>
      <v-flex>
        <v-text-field label="Email" v-model="form.email" autofocus />
        <v-text-field label="Пароль" v-model="form.password" />
        <v-btn outline block color="primary" :loading="loadingAuth" @click="fetchAuth()">
          Увійти
        </v-btn>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
  import { post } from '../../helpers/api'

  export default {
    data () {
      return {
        loadingAuth: false,
        form: {
          email: '',
          password: ''
        }
      }
    },
    activated () {
      this.$store.dispatch('templateSetTitle', 'Авторизація')
    },
    methods: {
      fetchAuth () {
        this.loadingAuth = true
      }
    }
  }
</script>
