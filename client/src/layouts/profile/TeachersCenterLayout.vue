<template>
  <section class="space-y-20">
    <PublishedCoursesLayout :user="user" />

    <DraftsCoursesLayout :user="user" />
  </section>
</template>

<script>
import PublishedCoursesLayout from '@/layouts/profile/myCourses/PublishedCoursesLayout'
import DraftsCoursesLayout from '@/layouts/profile/myCourses/DraftsCoursesLayout'

export default {
  name: 'TeachersCenterLayout',
  components: {
    PublishedCoursesLayout,
    DraftsCoursesLayout,
  },
  data () {
    return {
      user: {},
    }
  },
  mounted () {
    const { email } = JSON.parse(localStorage.getItem(process.env.VUE_APP_USER_KEY))
    this.user.email = email
  },
}
</script>
