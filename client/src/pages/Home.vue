<template>
  <main class="space-y-8">
    <!-- ENROLLED -->
    <EnrolledCoursesLayout :courses="courses" />

    <!-- SEARCH -->
    <section class="flex flex-col">
      <SearchBar
        v-model="search"
        :bg-gray="true"
        class="shadow"
      />

      <router-link
        :to="{ name: 'search' }"
        class="text-blue-900 text-sm underline self-end mt-4"
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
        class="block text-3xl leading-none font-semibold hover:underline"
      >
        See all subjects >
      </a>

      <a
        href="#"
        class="block text-3xl leading-none font-semibold hover:underline"
      >
        See all courses >
      </a>
    </section>
  </main>
</template>

<script>
import courses from '../../courses.json'

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
  data () {
    return {
      search: '',
      courses,
    }
  },
}
</script>
