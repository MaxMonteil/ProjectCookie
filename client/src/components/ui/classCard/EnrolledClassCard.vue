<template functional>
  <component
    :is="injections.components.BaseClassCard"
    :course-id="props.course.id"
  >
    <template #name>
      {{ props.course.name }}
    </template>

    <template #progress>
      Progress: {{ props.course.progress }}%
    </template>
  </component>
</template>

<script>
export default {
  name: 'EnrolledClassCard',
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
