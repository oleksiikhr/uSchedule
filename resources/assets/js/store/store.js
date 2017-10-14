// Vue libs
import Vue from 'vue'
import Vuex from 'vuex'

// Vue store
import userStore from './auth'

// Vue use
Vue.use(Vuex)

export default new Vuex.Store({
    modules: {
        userStore
    }
})
