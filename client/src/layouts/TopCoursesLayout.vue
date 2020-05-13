<template>
  <section class="flex flex-col">
    <h2 class="mb-6 text-3xl font-semibold leading-none">
      Top Courses
    </h2>

    <article class="space-y-4">
      <div>
        <button
          v-for="subject in subjects"
          :key="subject"
          class="ml-4 capitalize btn"
          :class="open === subject ? 'btn-green' : 'btn-inactive'"
          @click="open = subject"
        >
          {{ subject }}
        </button>
      </div>

      <div class="flex flex-col p-4 border border-green-500 rounded space-y-4">
        <ClassCardRow
          card="detailed"
          :courses="courses[open]"
          :tight="true"
        />

        <router-link
          :to="{ name: 'search', params: { options: { subject: open } } }"
          class="self-end text-sm text-green-900 underline"
        >
          See all
        </router-link>
      </div>
    </article>
  </section>
</template>

<script>
import ClassCardRow from '@/components/ui/classCard/ClassCardRow'

export default {
  name: 'TopCoursesLayout',
  components: {
    ClassCardRow,
  },
  data () {
    return {
      loading: true,
      courses: {},
      subjects: [],
      open: '',
    }
  },
  computed: {
    subjectCourses () {
      return this.courses.filter(course => course.subject === this.open)
    },
  },
  created () {
    this.fetchTopCourses()
  },
  mounted () {
  },
  methods: {
    async fetchTopCourses () {
      try {
        await this.fetchSubjects()
        await this.fetchSubjectCourse(null, [this.open])

        // start prefetching the other courses
        this.$api.courses.getBySubjects(this.subjects.slice(1))
      } catch (error) {
        this.error = error
      }

      this.loading = false
    },
    async fetchSubjects () {
      this.subjects = await this.$api.courses.getAllSubjects()
      this.open = this.subjects[0]
    },
    async fetchSubjectCourse (_, subjects) {
      this.courses = {
        ...await this.$api.courses.getBySubjects(subjects),
      }
    },
  },
}
</script>
