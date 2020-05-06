<template>
  <section class="flex flex-col">
    <h2 class="text-3xl leading-none font-semibold mb-6">
      Enrolled Courses
    </h2>

    <ClassCardRow
      card="enrolled"
      :courses="courses"
    />

    <a
      href="#"
      class="text-blue-900 text-sm underline self-end mt-4"
    >
      See all
    </a>
  </section>
</template>

<script>
import ClassCardRow from '@/components/ui/classCard/ClassCardRow'

export default {
  name: 'EnrolledCoursesLayout',
  components: {
    ClassCardRow,
  },
  props: {
    courses: {
      type: Array,
      required: true,
    },
  },
}
</script>
