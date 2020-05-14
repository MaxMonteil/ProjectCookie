<template>
  <section class="space-y-6">
    <!-- trick to embed an iframe with a fixed aspect ratio and width full -->
    <div
      class="relative"
      style="padding-top:56.25%;"
    >
      <iframe
        :src="lesson.link"
        frameborder="0"
        allowfullscreen
        class="absolute top-0 left-0 w-full h-full shadow-md"
      />
    </div>

    <div class="flex items-center justify-between">
      <router-link
        v-if="lesson.prevLessonId"
        :to="{ name: 'lesson', params: { courseId: lesson.courseId, sectionId: lesson.sectionId, lessonId: lesson.prevLessonId } }"
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

      <button
        class="btn btn-blue"
        :class="{ 'border-blue-200 bg-blue-200 text-blue-900': lesson.completed }"
        @click="toggleCompletion"
      >
        {{ lesson.completed ? 'Lesson completed!' : 'Mark Lesson as Completed' }}
      </button>

      <router-link
        v-if="lesson.nextLessonId"
        :to="{ name: 'lesson', params: { courseId: lesson.courseId, sectionId: lesson.sectionId, lessonId: lesson.nextLessonId } }"
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

    <div
      v-if="error"
      class="p-4 text-center text-white bg-red-500 rounded shadow"
    >
      <p>There was an error setting this lesson as complete:</p>
      <p class="font-bold">
        {{ error }}
      </p>
    </div>

    <div
      v-if="success"
      class="p-4 font-bold text-center text-white bg-green-500 rounded shadow"
    >
      <p>Lesson successfully marked as completed!</p>
    </div>

    <p>
      {{ lesson.description }}
    </p>
  </section>
</template>

<script>
export default {
  name: 'VideoLesson',
  props: {
    lesson: {
      type: Object,
      required: true,
    },
  },
  data () {
    return {
      loading: false,
      error: '',
      success: '',
    }
  },
  methods: {
    async toggleCompletion () {
      try {
        this.loading = true
        this.error = ''

        const email = JSON.parse(localStorage.getItem(process.env.VUE_APP_USER_KEY))

        const { message } = await this.$api.lessons.toggleCompletion({
          email: email || null,
          courseId: this.courseId,
          sectionId: this.sectionId,
          lessonId: this.lessonId,
        })

        this.success = message

        const id = setTimeout(() => {
          this.success = ''
          clearTimeout(id)
        }, 2000)
      } catch (error) {
        this.error = error
      }

      this.loading = false
    },
  },
}
</script>

<style scoped>
.bg-video {
  background: linear-gradient(155.44deg, #4299E1 16.29%, #2A4365 148.99%);
}
</style>
