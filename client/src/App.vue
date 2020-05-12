<template>
  <div
    id="app"
    :class="onAuthPage ? '' : 'px-64 pt-24 pb-32'"
  >
    <TheHeader v-if="!$route.matched.some(r => r.meta.hideHeader)" />

    <router-view />
  </div>
</template>

<script>
import TheHeader from '@/components/ui/TheHeader'

export default {
  components: {
    TheHeader,
  },
  computed: {
    onAuthPage () {
      return this.$route.matched.some(r => r.path.includes('auth'))
    },
  },
}
</script>
