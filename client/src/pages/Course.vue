<template>
  <div>
    <aside>
      <PaymentModal
        v-if="showModal"
        :course="course"
        @close="showModal = false"
      />
    </aside>

    <main v-if="error">
      <div class="p-4 text-center bg-red-500 rounded shadow">
        <p class="font-bold text-white">
          {{ error }}
        </p>
      </div>
    </main>

    <main
      v-else
      class="space-y-8"
    >
      <header class="space-y-2">
        <h1 class="text-3xl font-semibold leading-tight">
          {{ loading ? 'Loading...' : course.name }}
        </h1>

        <span class="flex items-center rounded space-x-2 divide-x-2 divide-gray-200">
          <span class="flex items-center">
            <div class="w-6 h-6 p-2 mr-2 bg-blue-900 rounded-full" />
            <p>{{ loading ? '...' : course.teacher }}</p>
          </span>
          <p class="pl-2 text-gray-600">{{ loading ? '...' : course.startDate }}</p>
          <p class="pl-2 text-gray-600">{{ loading ? '...' : course.studentCount }} Students</p>
        </span>
      </header>

      <p>{{ loading ? '...' : course.description }}</p>

      <div class="inline-block text-center space-y-2">
        <h2 class="text-lg font-bold text-blue-500">
          Course Price: {{ loading ? '...' : course.price }}$
        </h2>
        <button
          class="btn btn-blue"
          :class="{
            'border-blue-200 bg-blue-200 text-blue-900 cursor-wait shadow-none': loading
          }"
          :disabled="loading"
          @click="showModal = true"
        >
          {{ loading ? 'Loading...' : 'Enroll in this Class' }}
        </button>
      </div>

      <section class="space-y-6">
        <h2 class="text-2xl font-bold">
          Syllabus
        </h2>

        <div
          v-if="!loading"
          class="space-y-4 divide-y divide-gray-200"
        >
          <SyllabusSection
            v-for="section in course.syllabus"
            :key="section.id"
            :section="section"
          />
        </div>
      </section>
    </main>
  </div>
</template>

<script>
import PaymentModal from '@/components/ui/course/PaymentModal'
import SyllabusSection from '@/components/ui/course/SyllabusSection'

export default {
  name: 'Course',
  components: {
    PaymentModal,
    SyllabusSection,
  },
  props: {
    courseId: {
      type: String,
      required: true,
    },
  },
  data () {
    return {
      loading: true,
      error: '',
      showModal: false,
      course: {},
    }
  },
  created () {
    this.fetchCourseData()
  },
  methods: {
    async fetchCourseData () {
      try {
        this.loading = true
        this.error = ''

        this.course = await this.$api.courses.getOne({
          courseId: this.courseId,
        })
      } catch (error) {
        this.error = error
      }

      this.loading = false
    },
  },
}
</script>
