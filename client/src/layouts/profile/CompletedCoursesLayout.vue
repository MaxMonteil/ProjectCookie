<template>
  <section class="flex flex-col pt-20">
    <h2 class="mb-6 text-3xl font-semibold leading-tight">
      Completed Courses
    </h2>

    <div v-if="!error">
      <ClassCardRow
        v-if="courses.length >= 1"
        card="completed"
        :courses="courses"
      />

      <h3
        v-else
        class="text-lg font-bold text-gray-600"
      >
        You haven't completed into any courses yet...
      </h3>
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

export default {
  name: 'CompletedCoursesLayout',
  components: {
    ClassCardRow,
  },
  data () {
    return {
      loading: true,
      error: '',
      courses: [{}],
    }
  },
  created () {
    this.fetchCompletedCourses()
  },
  methods: {
    async fetchCompletedCourses () {
      try {
        this.loading = true
        this.error = ''

        const { email } = JSON.parse(localStorage.getItem(process.env.VUE_APP_USER_KEY))
        const { courses } = await this.$api.courses.getCompleted(email)
        this.courses = courses || []
      } catch (error) {
        this.error = error
      }

      this.loading = false
    },
  },
}
</script>
