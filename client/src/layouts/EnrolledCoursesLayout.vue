<template>
  <section class="flex flex-col">
    <h2 class="mb-6 text-3xl font-semibold leading-none">
      Enrolled Courses
    </h2>

    <p v-if="loading">
      Loading...
    </p>

    <ClassCardRow
      v-else
      card="enrolled"
      :courses="courses"
    />

    <a
      v-if="!showAll"
      href="#"
      class="self-end mt-4 text-sm text-blue-900 underline"
    >
      See all
    </a>
  </section>
</template>

<script>
import ClassCardRow from '@/components/ui/classCard/ClassCardRow'

export default {
  name: 'EnrolledCoursesLayout',
  components: {
    ClassCardRow,
  },
  props: {
    showAll: {
      type: Boolean,
      default: false,
    },
  },
  data () {
    return {
      loading: true,
      courses: [],
    }
  },
  created () {
    this.fetchEnrolledCourses()
  },
  methods: {
    async fetchEnrolledCourses () {
      const response = await fetch('../courses.json')
      const allCourses = await response.json()

      this.courses = allCourses.filter(course => course.enrolled)
      this.loading = false
    },
  },
}
</script>
