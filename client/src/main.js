import Vue from 'vue'
import App from './App.vue'
import router from './router'
import api from './api'
import '@/assets/css/main.css'

Vue.config.productionTip = false

Vue.use(api)

new Vue({
  router,
  render: h => h(App),
}).$mount('#app')
