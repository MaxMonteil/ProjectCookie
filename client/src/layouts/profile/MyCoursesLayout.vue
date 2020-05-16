<template>
  <section class="divide-y-2 divide-gray-200 space-y-20">
    <EnrolledCoursesLayout :show-all="true" />

    <CompletedCoursesLayout />
  </section>
</template>

<script>
import EnrolledCoursesLayout from '@/layouts/EnrolledCoursesLayout'
import CompletedCoursesLayout from '@/layouts/profile/CompletedCoursesLayout'

export default {
  name: 'MyCoursesLayout',
  components: {
    EnrolledCoursesLayout,
    CompletedCoursesLayout,
  },
}
</script>
