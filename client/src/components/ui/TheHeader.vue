<template>
  <header class="fixed top-0 left-0 flex items-center justify-between w-full px-32 py-4 bg-blue-500 shadow space-x-8">
    <h1 class="text-2xl font-bold text-white">
      <router-link :to="{ name: 'home' }">
        ProjectCookie
      </router-link>
    </h1>

    <form
      class="w-full"
      @submit.prevent="submitSearch"
    >
      <SearchBar
        v-if="!$route.matched.some(r => r.meta.hideHeaderSearchBar)"
        v-model="search"
        label="search"
        :with-opacity="true"
      />
    </form>

    <div class="w-8 h-8 p-4 bg-blue-900 rounded-full" />
  </header>
</template>

<script>
import SearchBar from '@/components/inputs/SearchBar'

export default {
  name: 'TheHeader',
  components: {
    SearchBar,
  },
  data () {
    return {
      search: '',
    }
  },
  methods: {
    submitSearch () {
      if (this.search.trim().length > 0) {
        this.$router.push({ name: 'search', query: { q: this.search.trim() } })
      }
    },
  },
}
</script>
