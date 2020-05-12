<template>
  <section class="flex flex-col">
    <h2 class="mb-6 text-3xl font-semibold leading-tight">
      Enrolled Courses
    </h2>

    <ClassCardRow
      card="enrolled"
      :courses="courses"
    />

    <router-link
      v-if="!showAll"
      :to="{ name: 'my-courses' }"
      class="self-end mt-4 text-sm text-blue-900 underline"
    >
      See all
    </router-link>
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
      courses: [{}],
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
