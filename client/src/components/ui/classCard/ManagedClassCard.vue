<template functional>
  <component
    :is="injections.components.BaseClassCard"
    :course-id="props.course.id"
  >
    <template #title>
      {{ props.course.title }}
    </template>

    <div class="flex justify-between">
      <button
        v-if="props.course.isPublished"
        class="btn btn-blue-sec"
      >
        View
      </button>

      <button class="btn btn-blue">
        Manage
      </button>
    </div>
  </component>
</template>

<script>
export default {
  name: 'ManagedClassCard',
  inject: {
    components: {
      default: {
        BaseClassCard: () => import('@/components/ui/classCard/BaseClassCard'),
      },
    },
  },
  props: {
    course: {
      type: Object,
      required: true,
    },
  },
}
</script>
