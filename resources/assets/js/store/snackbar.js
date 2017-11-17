// Vue libs
import Vue from 'Vue'
import Vuex from 'Vuex'

// Vue use
Vue.use(Vuex)

const state = {
  model: false,
  color: 'info'
}

const mutations = {
  SHOW (state, obj) {
    state.model = obj.model
    state.color = obj.color
  }
}

const actions = {
  snackbarShow: ({commit}, obj) => {
    commit('SHOW', obj)
  }
}

export default {
  state, mutations, actions
}

