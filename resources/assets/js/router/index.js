// Vue libs
import Vue from 'vue'
import VueRouter from 'vue-router'

// Other libs
import axios from 'axios'

// Views, components
import Home from '../views/Home.vue'

import Login from '../views/auth/Login.vue'
import Register from '../views/auth/Register.vue'
import Email from '../views/auth/Email.vue'

import Profile from '../views/users/Profile.vue'
import NotFound from '../views/NotFound.vue'
import ScheduleEdit from '../views/schedule/Edit.vue'

// Other components
import store from '../store/store'
import { post } from '../helpers/api'

// Vue use
Vue.use(VueRouter)

// Vue router
const router = new VueRouter({
  mode: 'history',
  routes: [
    { path: '/home', name: 'home', component: Home },

    { path: '/login', name: 'login', component: Login, meta: { isLogin: false } },
    { path: '/register', name: 'register', component: Register, meta: { isLogin: false } },
    { path: '/email', name: 'email', component: Email, meta: { isLogin: false } },

    { path: '/profile', name: 'profile', component: Profile, meta: { isLogin: true } },
    { path: '/schedule/:id/edit', name: 'schedule-edit', component: ScheduleEdit, meta: { isLogin: true } },
    { path: '*', name: 'not-found', component: NotFound }
  ]
})

// Axios global interceptors
axios.interceptors.response.use(null, err => {
  const token = window.localStorage.getItem('token')
  const originalRequest = err.config

  if (err.response.status === 401 && !originalRequest._retry) {
    originalRequest._retry = true

    if (token) {
      return post('/api/refresh-token')
          .then(res => {
            if (res.data.token) {
              window.localStorage.setItem('token', res.data.token)
              originalRequest.headers['Authorization'] = 'Bearer ' + res.data.token
            }
            return axios(originalRequest)
          })
          .catch(error => {
            if (error.response.status === 401) {
              window.localStorage.removeItem('token')
              router.push({ name: 'login' })
            }
            else {
              originalRequest.headers['Authorization'] = 'Bearer ' + window.localStorage.getItem('token')
              return axios(originalRequest)
            }
          })
    }

    router.push({ name: 'login' })
  }

  if (err.response.status !== 404 && err.response.data.message) {
    store.dispatch('snackbarShow', { color: 'error', text: err.response.data.message })
  }

  return Promise.reject(err)
})

// Protect router
router.beforeEach((to, from, next) => {
  let token = window.localStorage.getItem('token')

  let isLogin = to.meta.isLogin
  let isLoginUndefined = typeof isLogin === 'undefined'

  if (to.name !== 'login' && !isLoginUndefined && isLogin && !token) {
    next({ name: 'login' })
  }
  else if (to.name !== 'home' && !isLoginUndefined && !isLogin && token) {
    next({ name: 'home' })
  }

  next()
})

export default router
