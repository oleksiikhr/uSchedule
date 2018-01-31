import store from '../store/store'
import router from '../router/index'

/**
 * Primary data acquisition.
 *
 * @param data - Response from api
 * @param goProfile - Is go to Profile page
 *
 * @return void
 */
export function setAuth(data, goProfile = false) {
  if (data.token) {
    localStorage.setItem('token', data.token)
  }

  if (data.user) {
    store.dispatch('authSetUser', data.user)
    if (data.user.object) {
      store.dispatch('authSetObject', data.user.object)
    }
  }

  if (goProfile) {
    router.push({ name: 'profile' })
  }
}

/**
 * Logout from account and go to Login page.
 */
export function delAuth() {
  localStorage.removeItem('token')
  store.dispatch('authClearUser')
  router.push({ name: 'login' })
}
