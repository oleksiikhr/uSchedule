<template>
  <v-app :class="$store.state.template.bodyClass">
    <v-navigation-drawer persistent enable-resize-watcher clipped app :mini-variant.sync="mini" v-model="drawer">
      <v-toolbar flat>
        <v-list class="pa-0">
          <v-list-tile>
            <v-list-tile-avatar>
              <img src="/img/logo_200.png" alt="КНТЕУ"> <!-- TODO: need 48x48 -->
            </v-list-tile-avatar>
            <v-list-tile-content>
              <v-list-tile-title class="h-title">Розклад КНТЕУ</v-list-tile-title>
            </v-list-tile-content>
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
          <v-list-tile v-else :to="item.to" @click.native.stop="!!mini">
            <v-list-tile-action >
              <v-icon>{{ item.icon }}</v-icon>
            </v-list-tile-action>
            <v-list-tile-content>
              <v-list-tile-title>{{ item.text }}</v-list-tile-title>
            </v-list-tile-content>
            <v-list-tile-action v-if="item.subIcon">
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
      <v-toolbar-title style="width: 300px" class="ml-0 pl-3">
        <v-toolbar-side-icon @click.stop="drawer = !drawer" />
        {{ $store.state.template.title }}
      </v-toolbar-title>
      <v-text-field solo prepend-icon="search" placeholder="Пошук" />
      <v-btn class="ml-5" outline color="white"> <!-- TODO: ..-->
        <v-icon>notifications</v-icon>
        <span>Розклад дзвінків</span>
      </v-btn>
      <v-tooltip bottom>
        <v-btn v-if="!guest" icon @click="logout()" slot="activator">
          <v-icon>exit_to_app</v-icon>
        </v-btn>
        <span>Вийти</span>
      </v-tooltip>
    </v-toolbar>
    <main>
      <v-content>
        <keep-alive>
          <router-view />
        </keep-alive>
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
  import { get } from './helpers/api'

  export default {
    data () {
      return {
        drawer: true,
        mini: true,
        items: [
          {
            icon: 'home', text: 'Головна сторінка', to: '/home'
          }, {
            icon: 'account_circle', text: 'Профіль', to: '/profile',
            subIcon: 'edit', subText: 'Налаштування', subTo: '/edit/edit'
          }, {
            icon: 'description', text: 'Новини', to: '/news',
            subIcon: 'add', subText: 'Додати', subTo: '/news/create'
          }
        ]
      }
    },
    created () {
      this.$store.dispatch('templateSetTitle', 'Головна сторінка')
      if (localStorage.getItem('token')) {
        this.getProfile()
      }
    },
    computed: {
      guest () {
        return this.$store.state.auth.user === null
      }
    },
    methods: {
      getProfile () {
        get('/api/profile')
            .then(res => {
              this.$store.dispatch('authSetUser', res.data.token)
            })
      },
      logout () {
        localStorage.removeItem('token')
        this.$store.dispatch('authClearUser')
        this.$router.push({ name: 'login' }) // TODO: **
      }
    }
  }
</script>
