<template functional>
  <section
    class="w-56 bg-white rounded min-w-56 space-y-1"
    :class="props.color !== 'gray' ? 'shadow' : 'border-2 border-gray-200'"
  >
    <div
      v-if="props.showImage"
      class="w-full h-32 rounded-t"
      :class="props.color === 'blue' ? 'bg-blue-500' : 'bg-green-500'"
    />

    <article class="px-2 pb-1 space-y-1">
      <h1 class="text-lg font-bold">
        <router-link
          :to="{ name: 'course', params: { courseId: props.courseId } }"
        >
          <slot name="name" />
        </router-link>
      </h1>

      <p
        v-if="!!scopedSlots['start-date']"
        class="text-xs"
        :class="props.color === 'blue' ? 'text-blue-900' : 'text-green-900'"
      >
        <slot name="start-date" />
      </p>

      <p
        v-if="!!scopedSlots['student-count']"
        class="text-xs"
        :class="props.color === 'blue' ? 'text-blue-900' : 'text-green-900'"
      >
        <slot name="student-count" />
      </p>

      <p
        v-if="!!scopedSlots.progress"
        class="text-xs"
        :class="{
          'text-blue-900': props.color === 'blue',
          'text-green-900': props.color === 'green',
          'text-gray-600': props.color === 'gray',
        }"
      >
        <slot name="progress" />
      </p>

      <p
        v-if="!!scopedSlots['completed-on']"
        class="text-xs text-gray-600"
      >
        <slot name="completed-on" />
      </p>

      <slot />

      <p
        v-if="!!scopedSlots.description"
        class="h-20 overflow-hidden text-sm leading-snug"
      >
        <slot name="description" />
      </p>
    </article>
  </section>
</template>

<script>
export default {
  name: 'BaseClassCard',
  props: {
    courseId: {
      type: String,
      required: true,
    },
    showImage: {
      type: Boolean,
      default: true,
    },
    color: {
      type: String,
      default: 'blue',
    },
  },
}
</script>

<style scoped>
.min-w-56 {
  min-width: 14rem;
}
</style>
