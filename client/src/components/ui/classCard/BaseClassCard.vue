<template functional>
  <section class="bg-white min-w-56 w-56 rounded shadow space-y-1">
    <div
      class="rounded-t w-full h-32"
      :class="props.color === 'blue' ? 'bg-blue-500' : 'bg-green-500'"
    />

    <article class="space-y-1 px-2 pb-1">
      <h1 class="text-lg font-bold">
        <slot name="title" />
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
        class="text-sm h-20 leading-snug overflow-hidden"
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
