// Vue libs
import Vue from 'vue'
import Vuex from 'vuex'

// Vue store
import auth from './auth'
import snackbar from './snackbar'
import template from './template'

// Vue use
Vue.use(Vuex)

export default new Vuex.Store({
  modules: {
    auth, snackbar, template
  }
})
