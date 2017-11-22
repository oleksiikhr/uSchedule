// Vue libs
import Vue from 'vue'
import Vuex from 'vuex'

// Vue use
Vue.use(Vuex)

const state = {
  model: false,
  color: 'info',
  text: ''
}

const mutations = {
  SHOW (state, obj) {
    state.model = true
    state.color = obj.color
    state.text = obj.text
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

