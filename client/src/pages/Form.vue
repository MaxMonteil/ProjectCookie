<template>
  <div
    v-if="error"
    class="p-4 text-center bg-red-500 rounded shadow"
  >
    <p class="font-bold text-white">
      {{ error }}
    </p>
  </div>

  <main
    v-else
    class="space-y-8"
  >
    <component
      :is="formComponent"
      v-model="formData"
      :loading="loading"
      @submit="createCourse"
    />
  </main>
</template>

<script>
export default {
  name: 'Form',
  props: {
    formType: {
      type: String,
      required: true,
      validator (value) {
        return ['course', 'quiz'].includes(value)
      },
    },
    course: {
      type: Object,
      default: null,
    },
  },
  data () {
    return {
      loading: false,
      error: '',
      formData: null,
    }
  },
  computed: {
    formComponent () {
      const forms = {
        course: () => import('@/layouts/forms/CourseForm'),
      }

      return forms[this.formType]
    },
  },
  mounted () {
    if (this.course) {
      this.formData = this.course
    }
  },
  methods: {
    async createCourse () {
      try {
        this.loading = true
        this.error = ''

        await this.$api.courses.create(this.formData)
      } catch (error) {
        this.error = error
      }

      this.loading = false
    },
  },
}
</script>
