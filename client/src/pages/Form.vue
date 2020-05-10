<template>
  <h1 v-if="loading">
    loading...
  </h1>

  <main
    v-else
    class="space-y-8"
  >
    <component
      :is="formComponent"
      v-model="formData"
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
  },
  data () {
    return {
      loading: false,
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
}
</script>
