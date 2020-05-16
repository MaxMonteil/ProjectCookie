<template>
  <main class="divide-y-2 divide-gray-200 space-y-8">
    <!-- ENROLLED COURSES -->
    <EnrolledCoursesLayout v-if="loggedIn" />

    <!-- SEARCH -->
    <section class="flex flex-col">
      <SearchBar
        :bg-gray="true"
        class="pt-8 "
      />

      <router-link
        :to="{ name: 'search' }"
        class="self-end mt-4 text-sm text-blue-900 underline"
      >
        Advanced Search
      </router-link>
    </section>

    <!-- TOP COURSES -->
    <TopCoursesLayout />

    <!-- LINKS -->
    <section class="text-gray-600 space-y-6">
      <router-link
        :to="{ name: 'search', params: { getAllCourses: true } }"
        class="block pt-8 text-3xl font-semibold leading-none hover:underline"
      >
        See all courses &#8680;
      </router-link>
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
}
</script>
