import { auth } from './auth'
import { client } from './client'
import { courses } from './courses'
import { lessons } from './lessons'
import { search } from './search'
import { user } from './user'

const api = {
  install (Vue) {
    Vue.prototype.$api = {
      auth,
      client,
      courses,
      lessons,
      search,
      user,
    }
  },
}

export default api
