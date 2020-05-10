<template>
  <div class="flex flex-col pt-8 space-y-6">
    <InputText
      label="Quiz Name"
      :label-white="false"
      :bg-gray="true"
      :value="value.name"
      @input="$emit('input', { ...value, name: $event })"
    />

    <InputTextArea
      class="col-span-3"
      label="Description - optional"
      :label-white="false"
      :bg-gray="true"
      :rows="5"
      :value="value.description"
      @input="$emit('input', { ...value, description: $event })"
    />

    <label class="block text-sm font-medium leading-none text-blue-500">
      {{ value.questions.length }} Questions
      <button
        class="block mt-2 whitespace-no-wrap btn btn-blue"
        @click.prevent="showModal = true"
      >
        Edit Quiz
      </button>
    </label>

    <button
      class="self-end btn btn-red"
      @click.prevent="$emit('remove-lesson', { sectionIndex, lessonIndex })"
    >
      - Remove this Quiz
    </button>

    <QuestionsForm
      v-if="showModal"
      :value="value"
      @input="$emit('input', $event)"
      @close="showModal = false"
    />
  </div>
</template>

<script>
import InputText from '@/components/inputs/InputText'
import InputTextArea from '@/components/inputs/InputTextArea'
import QuestionsForm from '@/components/ui/forms/QuestionsForm'

export default {
  name: 'QuizForm',
  components: {
    InputText,
    InputTextArea,
    QuestionsForm,
  },
  props: {
    value: {
      type: Object,
      required: true,
    },
    lessonIndex: {
      type: Number,
      required: true,
    },
    sectionIndex: {
      type: Number,
      required: true,
    },
  },
  data () {
    return {
      showModal: false,
    }
  },
}
</script>
