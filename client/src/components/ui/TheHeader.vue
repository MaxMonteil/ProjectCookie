<template>
  <header class="bg-blue-500 px-32 py-4 w-full flex items-center space-x-8 shadow">
    <h1 class="text-2xl text-white font-bold">
      ProjectCookie
    </h1>

    <SearchBar
      v-model="search"
      label="search"
    />

    <div class="p-4 w-8 h-8 bg-blue-900 rounded-full" />
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
}
</script>
