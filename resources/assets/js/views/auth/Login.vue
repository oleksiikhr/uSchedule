<template>
  <v-container id="login" fluid>
    <v-layout column justify-center align-center>
      <v-flex>
        <v-text-field label="Email" v-model="form.email" ref="email" required />
        <v-text-field label="Пароль" v-model="form.password" type="password" required />
        <v-btn outline block color="primary" :loading="loading" @click="fetchAuth()">
          Увійти
        </v-btn>
        <div class="reg">
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
//        TODO: Delete default value
        form: {
          email: 'admin@example.com',
          password: 'admin123'
        }
      }
    },
    activated () {
      this.$store.dispatch('templateSetTitle', 'Авторизація')
      this.$refs.email.focus()
    },
    methods: {
      fetchAuth () {
        this.loading = true

        post('/api/login', this.form)
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
      actionGoRegisterForm () {
        this.$router.push({ name: 'register' })
      }
    }
  }
</script>
