import { auth } from './auth'
import { client } from './client'
import { courses } from './courses'
import { search } from './search'
import { user } from './user'

const api = {
  install (Vue) {
    Vue.prototype.$api = {
      auth,
      client,
      courses,
      search,
      user,
    }
  },
}

export default api
