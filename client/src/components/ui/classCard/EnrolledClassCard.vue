<template functional>
  <component :is="injections.components.BaseClassCard">
    <template #title>
      {{ props.course.title }}
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
