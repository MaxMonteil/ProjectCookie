<template functional>
  <component
    :is="injections.components.BaseClassCard"
    :course-id="props.course.id || ' '"
    color="gray"
    :show-image="false"
  >
    <template #name>
      {{ props.course.name || 'Loading' }}
    </template>

    <template #completed-on>
      Completed on: {{ props.course.completedOn || '...' }}
    </template>
  </component>
</template>

<script>
export default {
  name: 'CompletedClassCard',
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
