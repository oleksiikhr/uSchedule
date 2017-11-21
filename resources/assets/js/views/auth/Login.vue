<template>
  <v-container id="login" fluid>
    <v-layout column justify-center align-center>
      <v-flex>
        <v-text-field label="Email" v-model="form.email" autofocus />
        <v-text-field label="Пароль" v-model="form.password" type="password" />
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
//        TODO: Delete default value
        form: {
          email: 'admin@example.com',
          password: 'admin123'
        }
      }
    },
    activated () {
      this.$store.dispatch('templateSetTitle', 'Авторизація')
    },
    methods: {
      fetchAuth () {
        this.loadingAuth = true

        post('/api/login', this.form)
            .then(res => {
              this.$store.dispatch('authSetUser', res.data.user)
              localStorage.setItem('token', res.data.token)
              this.loadingAuth = false
              if (window.history.length > 1) {
                this.$router.go(-1)
              }
              else {
                this.$router.push({ name: 'home' })
              }
            })
            .catch(err => {
              // TODO: Show error message
              console.log(err.response.data)
              this.loadingAuth = false
            })
      }
    }
  }
</script>
