import store from '../store/store'

/**
 * Primary data acquisition.
 *
 * @param data - Response from api
 *
 * @return void
 */
export function init(data) {
  if (data.token) {
    localStorage.setItem('token', data.token)
  }

  if (data.user) {
    store.dispatch('authSetUser', data.user)
    if (data.user.object) {
      store.dispatch('authSetObject', data.user.object)
    }
  }
}