<template>
  <section class="flex flex-col space-y-6">
    <header class="flex items-center justify-between">
      <h2 class="text-3xl font-semibold leading-tight">
        Drafts
      </h2>

      <router-link
        class="text-lg font-bold text-gray-600 underline"
        :to="{ name: 'form', params: { formType: 'course' } }"
      >
        <span class="text-blue-500">+</span> Create a new course
      </router-link>
    </header>

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
        You don't have any drafts.
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
  name: 'DraftsCoursesLayout',
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
    this.fetchDraftCourses()
  },
  methods: {
    async fetchDraftCourses () {
      try {
        this.loading = true
        this.error = ''

        const { courses } = await this.$api.courses.getDrafts({
          user: this.user,
        })
        this.courses = courses
      } catch (error) {
        this.error = error
      }

      this.loading = false
    },
  },
}
</script>
