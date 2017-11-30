<template>
  <v-container id="register" class="auth" fluid>
    <v-layout column justify-center align-center>
      <v-flex>
        <v-text-field label="Email" v-model="form.email" ref="email" required />
        <v-text-field label="Пароль" v-model="form.password" type="password" required />
        <v-text-field label="Повторити пароль" v-model="form.password_repeat" type="password" required />
        <v-btn outline block color="primary" :loading="loading" @click="fetchRegister()">
          Зареєструватись
        </v-btn>
        <div class="act">
          <span @click="actionGoLoginForm()">
            <v-icon>keyboard_arrow_left</v-icon>
            Авторизація
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
          email: '',
          password: '',
          password_repeat: ''
        }
      }
    },
    activated () {
      this.$store.dispatch('templateSetTitle', 'Реєстрація')
      this.$refs.email.focus()
    },
    methods: {
      fetchRegister () {
        this.loading = true

        post('/api/register', this.form)
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
      }
    }
  }
</script>
