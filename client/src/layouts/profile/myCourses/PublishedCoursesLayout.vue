<template>
  <section class="flex flex-col space-y-6">
    <h2 class="text-3xl font-semibold leading-tight">
      Published Courses
    </h2>

    <div v-if="!error">
      <ClassCardRow
        v-if="courses.length >= 1"
        card="managed"
        :courses="courses"
      />

      <h3
        v-else
        class="text-lg font-bold text-gray-600"
      >
        You don't have any published courses.
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
  name: 'PublishedCoursesLayout',
  components: {
    ClassCardRow,
  },
  props: {
    user: {
      type: Object,
      required: true,
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
    this.fetchPublishedCourses()
  },
  methods: {
    async fetchPublishedCourses () {
      try {
        this.loading = true
        this.error = ''

        const { courses } = await this.$api.courses.getPublished({
          user: this.user,
        })
        this.courses = courses || []
      } catch (error) {
        this.error = error
      }

      this.loading = false
    },
  },
}
</script>
