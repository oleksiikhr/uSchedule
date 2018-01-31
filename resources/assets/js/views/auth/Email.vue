<template>
  <v-container id="email" class="auth" fluid>
    <v-layout column justify-center align-center>
      <v-flex>
        <v-text-field label="Email" v-model="form.email" ref="email" required autofocus />
        <v-btn outline block color="primary" :disabled="loading" :loading="loading" @click="fetchRestorePassword()">
          Відновити пароль
        </v-btn>
        <div class="act">
          <span @click="actionGoLoginForm()">
            <v-icon>keyboard_arrow_left</v-icon>
            Авторизація
          </span>
          <span @click="actionGoRegisterForm()">
            Реєстрація
            <v-icon>keyboard_arrow_right</v-icon>
          </span>
        </div>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
  import { setAuth } from '../../helpers/auth'
  import { post } from '../../helpers/api'

  export default {
    data () {
      return {
        loading: false,
        form: {
          email: ''
        }
      }
    },
    mounted () {
      this.$store.dispatch('templateSetTitle', 'Відновлення пароля')
    },
    methods: {
      fetchRestorePassword () {
        this.loading = true

        post('/api/restore-password', this.form)
            .then(res => {
              setAuth(res.data, true)
            })
            .catch(err => {
              this.loading = false
            })
      },
      actionGoLoginForm () {
        this.$router.push({ name: 'login' })
      },
      actionGoRegisterForm () {
        this.$router.push({ name: 'register' })
      }
    }
  }
</script>
