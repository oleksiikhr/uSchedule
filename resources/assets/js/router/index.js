// Vue libs
import Vue from 'vue'
import VueRouter from 'vue-router'

// Other libs
import axios from 'axios'

// Views, components
import Home from '../views/Home.vue'
import Profile from '../views/users/Profile.vue'
import Login from '../views/auth/Login.vue'
import NotFound from '../views/NotFound.vue'
import ScheduleEdit from '../views/schedule/Edit.vue'

// Vue use
Vue.use(VueRouter)

// Vue router
const router = new VueRouter({
  mode: 'history',
  routes: [
    { path: '/', redirect: { name: 'home' } },
    { path: '/home', name: 'home', component: Home },
    { path: '/profile', name: 'profile', component: Profile, meta: { isLogin: true } },
    { path: '/schedule/:id/edit', name: 'schedule-edit', component: ScheduleEdit },
    { path: '/login', name: 'login', component: Login },
    { path: '*', name: 'not-found', component: NotFound }
  ]
})

// Axios global interceptors
axios.interceptors.response.use(null, err => {
  let token = window.localStorage.getItem('token')

  const originalRequest = err.config

  if (err.response.status === 401 && !originalRequest._retry) {
    originalRequest._retry = true

    if (! token) {
      router.push({ name: 'login' })
    } else {
      return get('/api/refresh-token')
          .then(res => {
            if (res.data.token) {
              window.localStorage.setItem('token', res.data.token)
              originalRequest.headers['Authorization'] = 'Bearer ' + res.data.token
              return axios(originalRequest)
            }
          })
          .catch(err => {
            if (error.response.status === 401) {
              window.localStorage.removeItem('token')
              router.push({ name: 'login' })
            }
          })
    }
  }

  return Promise.reject(err)
})

// Protect router
router.beforeEach((to, from, next) => {
  let token = window.localStorage.getItem('token')

  if (to.meta.isLogin && !token) {
    next({ name: 'login' })
  } else if (!to.meta.isLogin && token) {
    next({ name: 'home' })
  } else {
    next()
  }
})

export default router
