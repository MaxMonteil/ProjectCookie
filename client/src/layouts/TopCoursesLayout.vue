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
          :courses="subjectCourses"
          :tight="true"
        />

        <a
          href="#"
          class="self-end text-sm text-green-900 underline"
        >
          See all
        </a>
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
  props: {
    courses: {
      type: Array,
      required: true,
    },
  },
  data () {
    return {
      open: '',
    }
  },
  computed: {
    subjects () {
      return [...new Set(this.courses.map(course => course.subject))]
    },
    subjectCourses () {
      return this.courses.filter(course => course.subject === this.open)
    },
  },
  mounted () {
    this.open = this.subjects[0]
  },
}
</script>
