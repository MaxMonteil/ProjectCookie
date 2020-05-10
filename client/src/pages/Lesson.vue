<template>
  <main class="space-y-6">
    <header>
      <h2 class="text-lg font-bold text-gray-600 underline">
        <router-link :to="{ name: 'course', params: { courseId } }">
          {{ courseName }}
        </router-link>
      </h2>

      <h1 class="text-3xl font-semibold leading-tight">
        {{ lesson.name }}
      </h1>
    </header>

    <component
      :is="lessonComponent"
      :lesson="lesson"
    />
  </main>
</template>

<script>
import VideoLesson from '@/components/ui/lesson/VideoLesson'
import QuizLesson from '@/components/ui/lesson/QuizLesson'

export default {
  name: 'Lesson',
  components: {
    VideoLesson,
  },
  props: {
    courseId: {
      type: String,
      required: true,
    },
    sectionId: {
      type: String,
      required: true,
    },
    lessonId: {
      type: String,
      required: true,
    },
  },
  data () {
    return {
      loading: true,
      courseName: '',
      lesson: {},
    }
  },
  computed: {
    lessonComponent () {
      return this.lesson.type === 'class'
        ? VideoLesson
        : QuizLesson
    },
  },
  created () {
    this.fetchLessonData()
  },
  methods: {
    async fetchLessonData () {
      const response = await fetch('../../../../../courses.json')
      const courses = await response.json()
      const course = courses.find(course => course.id === this.courseId)
      const section = course.syllabus.find(section => section.id === this.sectionId)

      this.courseName = course.name

      this.lesson = section.lessons.find(lesson => lesson.id === this.lessonId)
      this.loading = false
    },
  },
  beforeRouteUpdate (_, __, next) {
    this.fetchLessonData()
    next()
  },
}
</script>
