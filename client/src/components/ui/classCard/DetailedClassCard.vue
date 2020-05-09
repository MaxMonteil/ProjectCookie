<template functional>
  <component
    :is="injections.components.BaseClassCard"
    :course-id="'' + props.course.id"
    color="green"
  >
    <template #title>
      {{ props.course.title }}
    </template>

    <template #start-date>
      {{ props.course.startDate }}
    </template>

    <template #student-count>
      {{ props.course.studentCount }} Students
    </template>

    <template #description>
      {{ props.course.description.substring(0, 117) + '...' }}
    </template>
  </component>
</template>

<script>
export default {
  name: 'DetailedClassCard',
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
