<template>
  <section
    class="pl-2 pb-2 flex overflow-x-auto"
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
        return ['enrolled'].includes(value)
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
        // enrolled: EnrolledClassCard,
      }

      return cards[this.card]
    },
  },
}
</script>
