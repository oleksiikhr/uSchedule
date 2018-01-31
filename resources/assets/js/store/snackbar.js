const state = {
  model: false,
  color: 'info',
  text: ''
}

const mutations = {
  SNACKBAR_SHOW (state, obj) {
    state.model = true
    state.color = obj.color
    state.text = obj.text
  }
}

const actions = {
  snackbarShow: ({commit}, obj) => {
    commit('SNACKBAR_SHOW', obj)
  }
}

export default {
  state, mutations, actions
}

