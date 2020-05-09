<template>
  <section
    class="flex pb-2 pl-2 overflow-x-auto"
    :class="tight ? 'space-x-4' : 'space-x-8'"
  >
    <component
      :is="classCard"
      v-for="course in courses"
      :key="course.id"
      :course="course"
    />
  </section>
</template>

<script>
import EnrolledClassCard from '@/components/ui/classCard/EnrolledClassCard'

export default {
  name: 'ClassCardRow',
  components: {
    EnrolledClassCard,
  },
  props: {
    courses: {
      type: Array,
      required: true,
    },
    card: {
      type: String,
      required: true,
      validator (value) {
        // The value must match one of these strings
        return ['enrolled', 'detailed'].includes(value)
      },
    },
    tight: {
      type: Boolean,
      default: false,
    },
  },
  computed: {
    classCard () {
      const cards = {
        enrolled: () => import('@/components/ui/classCard/EnrolledClassCard'),
        detailed: () => import('@/components/ui/classCard/DetailedClassCard'),
      }

      return cards[this.card]
    },
  },
}
</script>
