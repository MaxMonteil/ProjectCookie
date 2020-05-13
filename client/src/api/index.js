import { client } from './client'
import { auth } from './auth'
import { user } from './user'
import { search } from './search'

const api = {
  install (Vue) {
    Vue.prototype.$api = {
      client,
      auth,
      user,
      search,
    }
  },
}

export default api
