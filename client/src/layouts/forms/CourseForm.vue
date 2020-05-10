<template>
  <section class="flex flex-col space-y-6">
    <router-link
      class="text-3xl font-semibold leading-tight"
      :to="{ name: 'teachers-center' }"
    >
      <h1 class="text-3xl font-semibold leading-tight">
        <span class="text-gray-600">&#x2717;</span> Create a new Course
      </h1>
    </router-link>

    <form class="grid grid-cols-8 row-gap-6 col-gap-8">
      <InputText
        v-model="course.name"
        class="col-span-7"
        label="Course Name"
        :label-white="false"
        :bg-gray="true"
      />

      <InputText
        v-model="course.subject"
        class="col-start-1 col-span-3"
        label="Subject"
        :label-white="false"
        :bg-gray="true"
      />

      <InputText
        v-model="course.language"
        class="col-span-3"
        label="Language of Instruction"
        :label-white="false"
        :bg-gray="true"
      />

      <InputText
        v-model="course.startDate"
        class="col-start-1 col-span-3"
        label="Start Date"
        :label-white="false"
        :bg-gray="true"
      />

      <InputText
        v-model="course.price"
        class="col-span-3"
        label="Price"
        :label-white="false"
        :bg-gray="true"
      />

      <InputTextArea
        v-model="course.description"
        class="col-start-1 col-span-7"
        label="Description"
        :label-white="false"
        :bg-gray="true"
      />

      <h2 class="mt-6 text-2xl font-semibold leading-tight col-span-8">
        Syllabus
      </h2>

      <div
        v-for="(section, i) in course.syllabus"
        :key="i"
        class="col-span-8 grid grid-cols-8 col-gap-8 row-gap-6"
      >
        <InputText
          v-model="section.name"
          class="col-span-7"
          label="Section Name"
          :label-white="false"
          :bg-gray="true"
        />

        <InputTextArea
          v-model="section.description"
          class="col-span-7"
          label="Description - optional"
          :label-white="false"
          :bg-gray="true"
          :rows="5"
        />

        <div class="pl-10 border-l-2 border-blue-200 col-start-2 col-span-7 divide-y-2 divide-gray-200 space-y-10">
          <div
            v-for="(lesson, j) in section.lessons"
            :key="j"
          >
            <LessonForm
              v-if="lesson.type === 'class'"
              v-model="section.lessons[j]"
              :lesson-index="j"
              :section-index="i"
              @remove-lesson="removeLesson"
            />

            <QuizForm
              v-if="lesson.type === 'quiz'"
              v-model="section.lessons[j]"
              :lesson-index="j"
              :section-index="i"
              @remove-lesson="removeLesson"
            />
          </div>

          <div class="flex items-start pt-8 col-start-2 col-span-4 space-x-8">
            <button
              class="btn btn-blue"
              @click.prevent="addLesson({ sectionIndex: i, type: 'class' })"
            >
              + Add a Lesson
            </button>

            <button
              class="btn btn-blue-sec"
              @click.prevent="addLesson({ sectionIndex: i, type: 'quiz' })"
            >
              + Add a Quiz
            </button>
          </div>
        </div>

        <button
          class="mb-10 whitespace-no-wrap btn btn-red col-start-1 col-span-2"
          @click.prevent="removeSection({ sectionIndex: i })"
        >
          - Remove this Section
        </button>
      </div>

      <div class="pt-8 border-t-2 border-gray-200 col-span-8">
        <button
          class="btn btn-blue"
          @click.prevent="addSection"
        >
          + Add a Section
        </button>
      </div>

      <div class="flex justify-end mt-16 space-x-8 col-start-5 col-span-4">
        <button class="btn btn-blue-sec">
          Save Draft
        </button>

        <button class="btn btn-blue">
          Save and Publish
        </button>
      </div>
    </form>
  </section>
</template>

<script>
import InputText from '@/components/inputs/InputText'
import InputTextArea from '@/components/inputs/InputTextArea'
import LessonForm from '@/components/ui/forms/LessonForm'
import QuizForm from '@/components/ui/forms/QuizForm'

export default {
  name: 'CourseForm',
  components: {
    InputText,
    InputTextArea,
    LessonForm,
    QuizForm,
  },
  props: {
    value: {
      type: Object,
      default: null,
    },
  },
  computed: {
    course () {
      return this.value || emptyCourse()
    },
  },
  methods: {
    addSection () {
      this.$emit('input', {
        ...this.course,
        syllabus: [...this.course.syllabus, emptySection()],
      })
    },
    removeSection ({ sectionIndex }) {
      this.$emit('input', {
        ...this.course,
        syllabus: this.course.syllabus.filter((_, i) => i !== sectionIndex),
      })
    },

    addLesson ({ sectionIndex, type }) {
      this.$emit('input', {
        ...this.course,
        syllabus: this.course.syllabus.map((section, i) => i === sectionIndex
          ? { ...section, lessons: section.lessons.concat(emptyLesson(type)) }
          : section,
        ),
      })
    },
    removeLesson ({ sectionIndex, lessonIndex }) {
      this.$emit('input', {
        ...this.course,
        syllabus: this.course.syllabus.map((section, i) => i === sectionIndex
          ? { ...section, lessons: section.lessons.filter((_, j) => j !== lessonIndex) }
          : section,
        ),
      })
    },
  },
}

const emptyCourse = () => ({
  name: '',
  subject: '',
  language: '',
  startDate: '',
  description: '',
  price: null,
  syllabus: [],
})

const emptySection = () => ({
  name: '',
  description: '',
  lessons: [],
})

const emptyLesson = type => {
  const lessonTypes = {
    class: { name: '', type: 'class', description: '', video: { file: null, link: '' } },
    quiz: { name: '', type: 'quiz', description: '', questions: [] },
  }

  return lessonTypes[type] || lessonTypes.class
}
</script>
