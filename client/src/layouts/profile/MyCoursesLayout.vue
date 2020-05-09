<template>
  <EnrolledCoursesLayout
    :show-all="true"
  />
</template>

<script>
import EnrolledCoursesLayout from '@/layouts/EnrolledCoursesLayout'

export default {
  name: 'MyCoursesLayout',
  components: {
    EnrolledCoursesLayout,
  },
}
</script>
