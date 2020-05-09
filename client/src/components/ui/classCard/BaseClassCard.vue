<template functional>
  <section class="w-56 bg-white rounded shadow min-w-56 space-y-1">
    <div
      class="w-full h-32 rounded-t"
      :class="props.color === 'blue' ? 'bg-blue-500' : 'bg-green-500'"
    />

    <article class="px-2 pb-1 space-y-1">
      <h1 class="text-lg font-bold">
        <router-link
          :to="{ name: 'course', params: { courseId: props.courseId } }"
        >
          <slot name="title" />
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
        :class="props.color === 'blue' ? 'text-blue-900' : 'text-green-900'"
      >
        <slot name="progress" />
      </p>

      <div
        v-if="props.showButtons"
        class="flex justify-between"
      >
        <button class="btn btn-blue-sec">
          View
        </button>

        <button class="btn btn-blue">
          Manage
        </button>
      </div>

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
    showButtons: {
      type: Boolean,
      default: false,
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
