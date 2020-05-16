<template>
  <main
    v-if="error"
    class="space-y-6"
  >
    <div class="p-4 text-center bg-red-500 rounded shadow">
      <p class="font-bold text-white">
        {{ error }}
      </p>
    </div>
  </main>

  <main
    v-else
    class="space-y-6"
  >
    <header>
      <h2 class="text-lg font-bold text-gray-600 underline">
        <router-link
          v-if="!loading"
          :to="{ name: 'course', params: { courseId } }"
        >
          {{ courseName }}
        </router-link>

        <span v-else>...</span>
      </h2>

      <h1 class="text-3xl font-semibold leading-tight">
        {{ loading ? 'Loading...' : lesson.name }}
      </h1>
    </header>

    <component
      :is="lessonComponent"
      v-if="!loading"
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
      error: '',
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
      try {
        this.loading = true
        this.error = ''

        const email = JSON.parse(localStorage.getItem(process.env.VUE_APP_USER_KEY))

        const { courseName, lesson } = await this.$api.lessons.getOne({
          email: email || null,
          courseId: this.courseId,
          sectionId: this.sectionId,
          lessonId: this.lessonId,
        })

        this.courseName = courseName
        this.lesson = lesson
      } catch (error) {
        this.error = error
      }

      this.loading = false
    },
  },
  beforeRouteUpdate (_, __, next) {
    this.fetchLessonData()
    next()
  },
}
</script>
