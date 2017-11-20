// Vue libs
import Vue from 'vue'
import Vuex from 'vuex'

// Vue use
Vue.use(Vuex)

const state = {
  title: ''
}

const mutations = {
  SET_TITLE (state, str) {
    state.title = str
  }
}

const actions = {
  templateSetTitle: ({commit}, str) => {
    commit('SET_TITLE', str)
  }
}

export default {
  state, mutations, actions
}
