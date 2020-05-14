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
}
</script>

<style scoped>
.bg-video {
  background: linear-gradient(155.44deg, #4299E1 16.29%, #2A4365 148.99%);
}
</style>
