<template>
  <div class="space-y-20">
    <section class="flex flex-col space-y-6">
      <h2 class="text-3xl font-semibold leading-tight">
        Published Courses
      </h2>

      <p v-if="published.loading">
        Loading...
      </p>

      <ClassCardRow
        v-else-if="!published.loading && published.courses.length > 0"
        card="managed"
        :courses="published.courses"
      />

      <p
        v-else
        class="text-lg text-gray-600"
      >
        No published courses
      </p>
    </section>

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

      <p v-if="drafts.loading">
        Loading...
      </p>

      <ClassCardRow
        v-else-if="!drafts.loading && drafts.courses.length > 0"
        card="managed"
        :courses="drafts.courses"
      />

      <p
        v-else
        class="text-lg text-gray-600"
      >
        No course drafts
      </p>
    </section>
  </div>
</template>

<script>
import ClassCardRow from '@/components/ui/classCard/ClassCardRow'

export default {
  name: 'TeachersCenterLayout',
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
      published: {
        courses: [],
        loading: true,
      },
      drafts: {
        courses: [],
        loading: true,
      },
    }
  },
  created () {
    this.fetchCourses({ property: 'published', field: 'isPublished' })
    this.fetchCourses({ property: 'drafts', field: 'isDraft' })
  },
  methods: {
    async fetchCourses ({ property, field }) {
      const response = await fetch('../courses.json')
      const allCourses = await response.json()

      this[property].courses = allCourses.filter(course => this.user.name === course.teacher && course[field])
      this[property].loading = false
    },
  },
}
</script>
