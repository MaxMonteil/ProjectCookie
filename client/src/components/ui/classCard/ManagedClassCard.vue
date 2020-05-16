<template>
  <BaseClassCard :course-id="course.id || ' '">
    <template #name>
      {{ course.name }}
    </template>

    <div class="flex justify-between">
      <router-link
        class="text-lg font-bold text-gray-600 underline"
        :to="{ name: 'form', params: { formType: 'course', course, } }"
      >
        Edit
      </router-link>

      <button
        v-if="course.isDraft"
        class="text-lg font-bold text-green-500 underline"
        :class="{
          'border-blue-200 bg-blue-200 text-blue-900 cursor-wait shadow-none': loading,
        }"
        :to="{ name: 'form', params: { formType: 'course' } }"
        @click="publishCourse"
      >
        Publish!
      </button>
    </div>
  </BaseClassCard>
</template>

<script>
export default {
  name: 'ManagedClassCard',
  components: {
    BaseClassCard: () => import('@/components/ui/classCard/BaseClassCard'),
  },
  props: {
    course: {
      type: Object,
      required: true,
    },
  },
  data () {
    return {
      loading: false,
      error: '',
    }
  },
  methods: {
    async publishCourse () {
      try {
        this.loading = true
        this.error = ''

        const { email } = JSON.parse(localStorage.getItem(process.envVUE_APP_USER_KEY))
        await this.$api.courses.publish({
          id: this.course.id,
          email,
        })
      } catch {
        this.error = 'Failed...'

        const id = setTimeout(() => {
          clearTimeout(id)
          this.error = ''
        }, 2000)
      }

      this.loading = false
    },
  },
}
</script>
