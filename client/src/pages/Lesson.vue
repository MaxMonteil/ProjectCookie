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

    <div class="relative bg-video">
      <svg
        class="absolute play"
        width="48"
        height="56"
        viewBox="0 0 48 56"
        fill="none"
        xmlns="http://www.w3.org/2000/svg"
      >
        <path
          d="M46.5 25.4019C48.5 26.5566 48.5 29.4434 46.5 30.5981L4.49999 54.8468C2.49999 56.0015 -2.64708e-06 54.5581 -2.54613e-06 52.2487L-4.26242e-07 3.75128C-3.25295e-07 1.44188 2.5 -0.00149082 4.5 1.15321L46.5 25.4019Z"
          fill="white"
        />
      </svg>
      <video class="w-full" />
    </div>

    <div class="flex items-center justify-between">
      <router-link
        v-if="lesson.prevLessonId"
        :to="{ name: 'lesson', params: { courseId, sectionId, lessonId: lesson.prevLessonId } }"
        class="text-blue-500 underline"
      >
        &#8678; Previous Lesson
      </router-link>
      <a
        v-else
        disabled
        class="text-gray-600 underline"
      >
        &#8678; Previous Lesson
      </a>

      <button class="btn btn-blue">
        Mark Lesson as Completed
      </button>

      <router-link
        v-if="lesson.nextLessonId"
        :to="{ name: 'lesson', params: { courseId, sectionId, lessonId: lesson.nextLessonId } }"
        class="text-blue-500 underline"
      >
        Next Lesson &#8680;
      </router-link>
      <a
        v-else
        disabled
        class="text-gray-600 underline"
      >
        Next Lesson &#8680;
      </a>
    </div>
  </main>
</template>

<script>
export default {
  name: 'Lesson',
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
  created () {
    this.fetchLessonData()
  },
  methods: {
    async fetchLessonData () {
      const response = await fetch('../../../../../courses.json')
      const courses = await response.json()
      const course = courses.find(course => course.id === this.courseId)
      const section = course.syllabus.find(section => section.id === this.sectionId)

      this.courseName = course.title

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

<style scoped>
.play {
  top: 45%;
  left: 49%;
}
.bg-video {
  background: linear-gradient(155.44deg, #4299E1 16.29%, #2A4365 148.99%);
}
</style>
