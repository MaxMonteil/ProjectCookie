<template>
  <section class="flex flex-col">
    <h2 class="mb-6 text-3xl font-semibold leading-tight">
      Completed Courses
    </h2>

    <p v-if="loading">
      Loading...
    </p>

    <ClassCardRow
      v-else
      card="completed"
      :courses="courses"
    />
  </section>
</template>

<script>
import ClassCardRow from '@/components/ui/classCard/ClassCardRow'

export default {
  name: 'CompletedCoursesLayout',
  components: {
    ClassCardRow,
  },
  data () {
    return {
      loading: true,
      courses: [],
    }
  },
  created () {
    this.fetchCompletedCourses()
  },
  methods: {
    async fetchCompletedCourses () {
      const response = await fetch('../../courses.json')
      const allCourses = await response.json()

      this.courses = allCourses.filter(course => course.completed)
      this.loading = false
    },
  },
}
</script>
