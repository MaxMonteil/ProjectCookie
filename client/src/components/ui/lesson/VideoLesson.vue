<template>
  <section class="space-y-6">
    <div class="bg-video">
      <video class="w-full" />
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

      <button class="btn btn-blue">
        Mark Lesson as Completed
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
}
</script>

<style scoped>
.bg-video {
  background: linear-gradient(155.44deg, #4299E1 16.29%, #2A4365 148.99%);
}
</style>
