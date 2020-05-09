<template>
  <section class="flex flex-col">
    <h2 class="mb-6 text-3xl font-semibold leading-none">
      Enrolled Courses
    </h2>

    <ClassCardRow
      card="enrolled"
      :courses="courses"
    />

    <a
      href="#"
      class="self-end mt-4 text-sm text-blue-900 underline"
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
