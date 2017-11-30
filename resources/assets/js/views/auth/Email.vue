<template>
  <v-container id="email" class="auth" fluid>
    <v-layout column justify-center align-center>
      <v-flex>
        <v-text-field label="Email" v-model="form.email" ref="email" required />
        <v-btn outline block color="primary" :loading="loading" @click="fetchRestorePassword()">
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
    activated () {
      this.$store.dispatch('templateSetTitle', 'Відновлення пароля')
      this.$refs.email.focus()
    },
    methods: {
      fetchRestorePassword () {
        this.loading = true

        post('/api/restore-password', this.form)
            .then(res => {
              this.$store.dispatch('authSetUser', res.data.user)
              localStorage.setItem('token', res.data.token)
              this.loading = false
              this.$router.push({ name: 'profile' })
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
