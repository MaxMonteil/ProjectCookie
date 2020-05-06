<template>
  <div
    id="app"
    class="px-64 py-32"
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
