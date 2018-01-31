<template>
  <v-app :class="$store.state.template.bodyClass">
    <v-navigation-drawer persistent enable-resize-watcher clipped app :mini-variant.sync="mini" v-model="drawer">
      <v-toolbar flat>
        <v-list class="pa-0">
          <v-list-tile>
            <template v-if="guest">
              <v-list-tile-avatar>
                <!-- TODO: Our logo -->
              </v-list-tile-avatar>
              <v-list-tile-content>
                <v-list-tile-title class="h-title">u-Schedule</v-list-tile-title>
              </v-list-tile-content>
            </template>
            <template v-else>
              <v-list-tile-avatar>
                <img v-if="objectImage" :src="objectImage" alt="КНТЕУ"> <!-- TODO: need 48x48 -->
                <!-- TODO: v-else => no-image.png* -->
              </v-list-tile-avatar>
              <v-list-tile-content>
                <v-list-tile-title class="h-title">{{ objectName }}</v-list-tile-title>
              </v-list-tile-content>
            </template>
            <v-list-tile-action>
              <v-btn icon @click.native.stop="mini = !mini">
                <v-icon>chevron_left</v-icon>
              </v-btn>
            </v-list-tile-action>
          </v-list-tile>
        </v-list>
      </v-toolbar>
      <v-list class="pt-0">
        <template v-for="(item, i) in items">
          <v-divider v-if="item.divider" dark class="my-2" :key="i" />
          <v-list-tile v-else-if="(item.isAuth && !guest) || !item.isAuth" :to="item.to" @click.native.stop="!!mini">
            <v-list-tile-action>
              <v-icon>{{ item.icon }}</v-icon>
            </v-list-tile-action>
            <v-list-tile-content>
              <v-list-tile-title>{{ item.text }}</v-list-tile-title>
            </v-list-tile-content>
            <v-list-tile-action v-if="item.subIcon && ((item.subIsAuth && !guest) || !item.subIsAuth)">
              <v-tooltip bottom>
                <v-btn icon ripple :to="item.subTo" slot="activator">
                  <v-icon>{{ item.subIcon }}</v-icon>
                </v-btn>
                <span v-if="item.subText">{{ item.subText }}</span>
              </v-tooltip>
            </v-list-tile-action>
          </v-list-tile>
        </template>
      </v-list>
    </v-navigation-drawer>
    <v-toolbar class="light-blue darken-2" flat dark app>
      <v-toolbar-title style="width: 300px" class="toolbar-title ml-0 pl-3">
        <v-toolbar-side-icon @click.stop="drawer = !drawer" />
        <span>{{ $store.state.template.title }}</span>
      </v-toolbar-title>
      <v-text-field solo prepend-icon="search" placeholder="Пошук" />
      <v-btn v-if="!guest" class="ml-5" outline color="white"> <!-- TODO: ..-->
        <v-icon>notifications</v-icon>
        <span>Розклад дзвінків</span>
      </v-btn>
      <v-tooltip v-if="!guest" bottom>
        <v-btn icon @click="fetchSendLogout()" slot="activator">
          <v-icon>exit_to_app</v-icon>
        </v-btn>
        <span>Вийти</span>
      </v-tooltip>
      <v-tooltip v-else bottom>
        <v-btn icon @click="goLogin()" slot="activator">
          <v-icon>lock_outline</v-icon>
        </v-btn>
        <span>Авторизація</span>
      </v-tooltip>
    </v-toolbar>
    <main>
      <v-content>
        <router-view />
      </v-content>
    </main>

    <v-snackbar
            :color="$store.state.snackbar.color"
            v-model="$store.state.snackbar.model"
            :timeout="5000"
            top
    >
      {{ $store.state.snackbar.text }}
      <v-btn dark flat @click.native="$store.state.snackbar.model = false">Закрити</v-btn>
    </v-snackbar>
  </v-app>
</template>

<script>
  import { objGetImage, objGetName } from './helpers/object'
  import { setAuth, delAuth } from './helpers/auth'
  import { get, post } from './helpers/api'

  export default {
    data () {
      return {
        drawer: true,
        mini: true,
        items: [
          {
            icon: 'home', text: 'Головна сторінка', to: '/home'
          }, {
            icon: 'account_circle', text: 'Профіль', to: '/profile', isAuth: true,
            subIcon: 'settings', subText: 'Налаштування', subTo: '/edit/edit'
          }, {
            icon: 'description', text: 'Новини', to: '/news',
            subIcon: 'add', subText: 'Додати', subTo: '/news/create', subIsAuth: true
          }
        ]
      }
    },
    mounted () {
      this.$store.dispatch('templateSetTitle', 'Головна сторінка')
      localStorage.getItem('token') && this.fetchGetProfile()
    },
    computed: {
      guest () {
        return this.$store.state.auth.user === null
      },
      objectImage () {
        return objGetImage(this.$store.state.auth.object)
      },
      objectName () {
        return objGetName(this.$store.state.auth.object)
      }
    },
    methods: {
      fetchGetProfile () {
        get('/api/profile')
            .then(res => {
              setAuth(res.data)
            })
      },
      fetchSendLogout () {
        post('/api/logout')
            .then(res => {
              delAuth()
            })
      },
      goLogin () {
        this.$router.push({ name: 'login' })
      }
    }
  }
</script>
