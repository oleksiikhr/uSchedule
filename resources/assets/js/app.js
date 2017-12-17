// Other libs
window._ = require('lodash')
window.$ = window.jQuery = require('jquery')
window.axios = require('axios')
window.moment = require('moment')

// Other config
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'

// Vue libs
import Vue from 'vue'
import Vuetify from 'vuetify'

// Vue views
import App from './App.vue'

// Vue files
import router from './router/index'
import store from './store/store'

// Vue use
Vue.use(Vuetify)

const app = new Vue({
  el: '#app',
  template: '<app></app>',
  components: { App },
  store,
  router
})
