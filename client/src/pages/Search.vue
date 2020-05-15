<template>
  <main>
    <!-- SEARCH -->
    <SearchBar
      #default="{ courses, error, loading, searchTerm }"
      :search-query="this.$route.query.q"
      :bg-gray="true"
      :with-blur="false"
      :show-button="true"
      :show-advanced="true"
      :get-all-courses="getAllCourses"
    >
      <div class="space-y-6">
        <header class="flex items-end justify-between">
          <h1 class="text-3xl font-semibold leading-none">
            Results {{ searchTerm ? `for: ${searchTerm}` : '' }}
          </h1>
        </header>

        <section
          v-if="error"
          class="p-4 text-center text-white bg-red-500 rounded shadow"
        >
          <p>Unable to fetch results:</p>

          <p class="font-bold">
            {{ error }}
          </p>
        </section>

        <section
          v-if="!error && courses.length"
          class="items-center grid grid-cols-5 gap-8"
        >
          <DetailedClassCard
            v-for="(course, i) in courses"
            :key="course.id || i"
            :course="course"
          />
        </section>

        <p
          class="text-2xl font-bold text-gray-600"
        >
          No results...
        </p>
      </div>
    </SearchBar>
  </main>
</template>

<script>
import SearchBar from '@/components/inputs/SearchBar.vue'
import DetailedClassCard from '@/components/ui/classCard/DetailedClassCard'

export default {
  name: 'Search',
  components: {
    SearchBar,
    DetailedClassCard,
  },
  props: {
    getAllCourses: {
      type: Boolean,
      default: false,
    },
  },
}
</script>

<style scoped>
.items-center {
  justify-items: center;
}
</style>
