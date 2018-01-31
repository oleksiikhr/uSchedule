const state = {
  title: '',
  bodyClass: ''
}

const mutations = {
  SET_TITLE (state, str) {
    state.title = str
  },
  SET_BODY_CLASS (state, str) {
    state.bodyClass = str
  }
}

const actions = {
  templateSetTitle: ({commit}, str) => {
    commit('SET_TITLE', str)
  },
  templateSetBodyClass: ({commit}, str) => {
    commit('SET_BODY_CLASS', str)
  }
}

export default {
  state, mutations, actions
}
