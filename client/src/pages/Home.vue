<template>
  <h1 v-if="loading">
    loading...
  </h1>

  <main
    v-else
    class="space-y-8"
  >
    <!-- ENROLLED -->
    <EnrolledCoursesLayout v-if="loggedIn" />

    <!-- SEARCH -->
    <section class="flex flex-col">
      <form @submit.prevent="submitSearch">
        <SearchBar
          v-model="search"
          :bg-gray="true"
          class="shadow"
        />
      </form>

      <router-link
        :to="{ name: 'search' }"
        class="self-end mt-4 text-sm text-blue-900 underline"
      >
        Advanced Search
      </router-link>
    </section>

    <!-- TOP -->
    <TopCoursesLayout :courses="courses" />

    <!-- LINKS -->
    <section class="text-gray-600 space-y-6">
      <a
        href="#"
        class="block text-3xl font-semibold leading-none hover:underline"
      >
        See all subjects >
      </a>

      <a
        href="#"
        class="block text-3xl font-semibold leading-none hover:underline"
      >
        See all courses >
      </a>
    </section>
  </main>
</template>

<script>
import EnrolledCoursesLayout from '@/layouts/EnrolledCoursesLayout'
import TopCoursesLayout from '@/layouts/TopCoursesLayout'
import SearchBar from '@/components/inputs/SearchBar'

export default {
  name: 'Home',
  components: {
    EnrolledCoursesLayout,
    TopCoursesLayout,
    SearchBar,
  },
  props: {
    loggedIn: {
      type: Boolean,
      default: false,
    },
  },
  data () {
    return {
      loading: true,
      search: '',
      courses: [],
    }
  },
  created () {
    this.fetchCourses()
  },
  methods: {
    submitSearch () {
      if (this.search.trim().length > 0) {
        this.$router.push({ name: 'search', query: { q: this.search.trim() } })
      }
    },
    async fetchCourses () {
      const response = await fetch('./courses.json')
      this.courses = await response.json()
      this.loading = false
    },
  },
}
</script>
