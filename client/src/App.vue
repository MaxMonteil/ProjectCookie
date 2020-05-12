<template>
  <div
    id="app"
    :class="onAuthPage ? '' : 'px-64 pt-24 pb-32'"
  >
    <TheHeader
      v-if="!$route.matched.some(r => r.meta.hideHeader)"
      :logged-in="loggedIn"
    />

    <router-view :logged-in="loggedIn" />
  </div>
</template>

<script>
import TheHeader from '@/components/ui/TheHeader'

export default {
  name: 'App',
  components: {
    TheHeader,
  },
  data () {
    return {
      loggedIn: false,
    }
  },
  computed: {
    onAuthPage () {
      return this.$route.matched.some(r => r.path.includes('auth'))
    },
  },
  watch: {
    $route: {
      immediate: true,
      handler () {
        this.loggedIn = !!localStorage.getItem(process.env.VUE_APP_USER_KEY)
      },
    },
  },
}
</script>
