<template>
  <article>
    <h3
      class="mt-4 text-lg font-bold text-blue-500 cursor-pointer"
      @click="open = !open"
    >
      {{ section.name }}
    </h3>

    <div
      v-show="open"
      class="ml-1 space-y-3"
    >
      <p>{{ section.description }}</p>
      <ol class="ml-2 space-y-4">
        <li
          v-for="(lesson, i) in section.lessons"
          :key="lesson.id"
        >
          <p><span class="mr-2">{{ i + 1 }}</span>{{ lesson.name }}</p>
        </li>
      </ol>
    </div>
  </article>
</template>

<script>
export default {
  name: 'SyllabusChapter',
  props: {
    section: {
      type: Object,
      required: true,
    },
  },
  data () {
    return {
      open: false,
    }
  },
}
</script>
