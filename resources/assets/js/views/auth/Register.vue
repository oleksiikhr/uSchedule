<template>
  <v-container id="register" class="auth" fluid>
    <v-layout column justify-center align-center>
      <v-flex>
        <!-- TODO: translate label -->
        <v-select
                label="University / school"
                autocomplete
                :loading="select.loading"
                cache-items
                required
                :items="select.items"
                item-value="id"
                item-text="name"
                :search-input.sync="select.search"
                v-model="form.object_id"
                ref="object"
        />
        <v-text-field label="Email" v-model="form.email" required />
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
  import { init } from "../../helpers/auth";
  import { get, post } from '../../helpers/api'

  export default {
    data () {
      return {
        loading: false,
        form: {
          email: '',
          password: '',
          password_repeat: '',
          object_id: null
        },
        select: {
          search: null,
          loading: false,
          items: []
        }
      }
    },
    activated () {
      this.$store.dispatch('templateSetTitle', 'Реєстрація')
      this.$refs.object.focus()
    },
    computed: {
      selectSearch () {
        return this.select.search
      }
    },
    methods: {
      fetchRegister () {
        this.loading = true

        post('/api/register', this.form)
            .then(res => {
              init(res.data)
              this.loading = false
              this.$router.push({ name: 'profile' })
            })
            .catch(err => {
              this.loading = false
            })
      },
      fetchGetObjects () {
        this.select.loading = true

        get('/api/objects', {
          search: this.select.search
        })
            .then(res => {
              this.select.items = res.data
              this.select.loading = false
            })
            .catch(err => {
              this.select.loading = false
            })
      },
      actionGoLoginForm () {
        this.$router.push({ name: 'login' })
      }
    },
    watch: {
      selectSearch (val) {
        val && this.fetchGetObjects(val)
      }
    }
  }
</script>
