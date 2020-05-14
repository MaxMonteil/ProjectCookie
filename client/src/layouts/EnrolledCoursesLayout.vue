<template>
  <section class="flex flex-col">
    <h2 class="mb-6 text-3xl font-semibold leading-tight">
      Enrolled Courses
    </h2>

    <div v-if="!error">
      <ClassCardRow
        v-if="courses.length >= 1"
        card="enrolled"
        :courses="courses"
      />

      <h3
        v-else
        class="text-lg font-bold text-gray-600"
      >
        You haven't enrolled into any courses yet...
      </h3>

      <router-link
        v-if="!showAll && !loading"
        :to="{ name: 'my-courses' }"
        class="self-end mt-4 text-sm text-blue-900 underline"
      >
        See all
      </router-link>
    </div>

    <div
      v-else
      class="p-4 text-center bg-red-500 rounded shadow"
    >
      <p class="font-bold text-white">
        {{ error }}
      </p>
    </div>
  </section>
</template>

<script>
import ClassCardRow from '@/components/ui/classCard/ClassCardRow'

const ENROLLED_FETCH_LIMIT = 4

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
      error: '',
      courses: [{}],
    }
  },
  created () {
    this.fetchEnrolledCourses()
  },
  methods: {
    async fetchEnrolledCourses () {
      try {
        this.loading = true
        this.error = ''

        const { courses } = await this.$api.courses.getEnrolled(
          this.showAll
            ? { limit: ENROLLED_FETCH_LIMIT }
            : null,
        )

        this.courses = courses
      } catch (error) {
        this.error = error
      }

      this.loading = false
    },
  },
}
</script>
