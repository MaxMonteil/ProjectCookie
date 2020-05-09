<template>
  <div>
    <aside>
      <PaymentModal
        v-if="showModal"
        :course="course"
        @close="showModal = false"
      />
    </aside>

    <main class="space-y-8">
      <header class="space-y-2">
        <h1 class="text-3xl font-semibold leading-tight">
          {{ course.title }}
        </h1>

        <span class="flex items-center rounded space-x-2 divide-x-2 divide-gray-200">
          <span class="flex items-center">
            <div class="w-6 h-6 p-2 mr-2 bg-blue-900 rounded-full" />
            <p>{{ course.teacher }}</p>
          </span>
          <p class="pl-2 text-gray-600">{{ course.startDate }}</p>
          <p class="pl-2 text-gray-600">{{ course.studentCount }} Students</p>
        </span>
      </header>

      <div class="flex flex-col">
        <p>{{ course.description }}</p>

        <button class="self-end text-gray-600 underline">
          Read More
        </button>
      </div>

      <div class="inline-block text-center space-y-2">
        <h2 class="text-lg font-bold text-blue-500">
          Course Price: {{ course.price }}$
        </h2>
        <button
          class="btn btn-blue"
          @click="showModal = true"
        >
          Enroll in this Class
        </button>
      </div>

      <section class="space-y-6">
        <h2 class="text-2xl font-bold">
          Syllabus
        </h2>

        <div class="space-y-4 divide-y divide-gray-200">
          <SyllabusSection
            v-for="section in course.syllabus"
            :key="section.name"
            :section="section"
          />
        </div>
      </section>
    </main>
  </div>
</template>

<script>
import PaymentModal from '@/components/ui/PaymentModal'
import SyllabusSection from '@/components/ui/course/SyllabusSection'

export default {
  name: 'Course',
  components: {
    PaymentModal,
    SyllabusSection,
  },
  props: {
    id: {
      type: String,
      required: true,
    },
  },
  data () {
    return {
      showModal: false,
      loading: true,
      course: {},
    }
  },
  created () {
    this.fetchCourseData()
  },
  methods: {
    async fetchCourseData () {
      const response = await fetch('../courses.json')
      const courses = await response.json()

      this.course = courses.find(course => course.id.toString() === this.id)
      this.loading = false
    },
  },
}
</script>
