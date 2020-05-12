import { client } from './client'
import { auth } from './auth'

const api = {
  install (Vue) {
    Vue.prototype.$api = {
      client,
      auth,
    }
  },
}

export default api
