// Vue libs
import Vue from 'vue'
import Vuex from 'vuex'

// Vue use
Vue.use(Vuex)

const state = {
  user: null
}

const mutations = {
  SET_USER (state, obj) {
    state.user = obj
  },
  CLEAR_USER (state) {
    state.user = null
  }
}

const actions = {
  authSetUser: ({commit}, obj) => {
    commit('SET_USER', obj)
  },
  authClearUser: ({commit}) => {
    commit('CLEAR_USER')
  }
}

export default {
  state, mutations, actions
}
