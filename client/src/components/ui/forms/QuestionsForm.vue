<template>
  <PopupBase
    label="quiz form"
    @close="$emit('close')"
  >
    <template #backdrop>
      <div class="absolute w-full h-screen -mt-6 bg-black bg-opacity-25" />
    </template>

    <div class="w-4/5 px-16 py-12 overflow-y-auto bg-white rounded shadow-lg h-90 space-y-8">
      <h3
        class="text-3xl font-semibold leading-tight cursor-pointer"
        @click.prevent="$emit('close')"
      >
        <span class="text-gray-600">&#x2717;</span> Edit Quiz questions
      </h3>

      <ol class="space-y-8 divide-y-2 divide-gray-200">
        <li
          v-for="({ question, answers, correct }, q) in value.questions"
          :key="q"
          class="flex flex-col pt-8 space-y-6"
        >
          <InputTextArea
            :label="'Question ' + (q + 1)"
            :label-white="false"
            :bg-gray="true"
            :rows="2"
            :value="question"
            @input="updateQuestion(q, { question: $event, answers: [...answers], correct })"
          />

          <div
            v-if="answers.length > 0"
            class="space-y-6"
          >
            <div
              v-for="(answer, a) in answers"
              :key="a"
            >
              <label
                class="block"
              >
                <input
                  class="relative w-4 h-4 mr-1 border border-gray-600 rounded-full appearance-none transition-all ease-linear duration-75 top-1"
                  type="radio"
                  :checked="answer === correct"
                  :name="q"
                  :value="answer"
                  @change="updateQuestion(q, { question, answers: [...answers], correct: $event.target.value })"
                >
                {{ answer }}
              </label>
              <button
                class="ml-4 text-red-500 underline"
                @click.prevent="updateQuestion(q, {
                  question,
                  answers: answers.filter((_, i) => i !== a),
                  correct: answer === correct ? '' : correct,
                })"
              >
                &#x2717; remove
              </button>
            </div>
          </div>

          <div class="flex items-end space-x-8">
            <InputText
              v-model="newAnswers[q]"
              class="w-1/4"
              label="Option"
              :label-white="false"
              :bg-gray="true"
            />

            <button
              class="btn btn-blue"
              @click.prevent="addAnswer(q)"
            >
              Add answer
            </button>
          </div>

          <button
            class="self-end btn btn-red"
            @click.prevent="removeQuestion(q)"
          >
            - Remove Question
          </button>
        </li>
      </ol>

      <div class="w-full pt-8 border-t-2 border-gray-200">
        <button
          class="btn btn-blue"
          @click.prevent="addQuestion"
        >
          + Add Question
        </button>
      </div>
    </div>
  </PopupBase>
</template>

<script>
import PopupBase from '@/components/popups/PopupBase'
import InputText from '@/components/inputs/InputText'
import InputTextArea from '@/components/inputs/InputTextArea'

export default {
  name: 'QuestionsForm',
  components: {
    PopupBase,
    InputText,
    InputTextArea,
  },
  props: {
    value: {
      type: Object,
      required: true,
    },
  },
  data () {
    return {
      newAnswers: new Array(this.value.questions.length).fill(''),
    }
  },
  methods: {
    addQuestion () {
      this.$emit('input', { ...this.value, questions: [...this.value.questions, emptyQuestion()] })
      this.newAnswers.push('')
    },
    updateQuestion (q, newValue) {
      this.$emit('input', {
        ...this.value,
        questions: this.value.questions.map((question, i) => i === q ? newValue : question),
      })
    },
    removeQuestion (q) {
      this.$emit('input', {
        ...this.value,
        questions: this.value.questions.filter((_, i) => i !== q),
      })

      this.newAnswers.splice(q, 1)
    },
    addAnswer (q) {
      if (this.newAnswers[q].trim().length === 0 || this.value.questions[q].answers.includes(this.newAnswers[q])) return

      this.$emit('input', {
        ...this.value,
        questions: this.value.questions.map((question, i) =>
          i === q
            ? { ...question, answers: question.answers.concat(this.newAnswers[q]) }
            : question,
        ),
      })

      this.newAnswers[q] = ''
    },
  },
}

const emptyQuestion = () => ({
  question: '',
  answers: [],
  correct: '',
})
</script>

<style scoped>
.h-90 {
  height: 90%;
}
.top-1 {
  top: 0.125rem;
}

input:checked {
  border: 5px solid rgb(66, 153, 225);
}
</style>
