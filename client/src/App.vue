<template>
  <div
    id="app"
    class="px-64 pt-24 pb-32"
  >
    <TheHeader />

    <router-view />
  </div>
</template>

<script>
import TheHeader from '@/components/ui/TheHeader'

export default {
  components: {
    TheHeader,
  },
}
</script>
