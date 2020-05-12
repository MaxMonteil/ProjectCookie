import { client } from './client'
import { auth } from './auth'
import { user } from './user'

const api = {
  install (Vue) {
    Vue.prototype.$api = {
      client,
      auth,
      user,
    }
  },
}

export default api
