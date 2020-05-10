<template>
  <div class="flex flex-col pt-8 space-y-6">
    <InputText
      label="Lesson Name"
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

    <div class="flex items-end space-x-6 col-span-7">
      <label class="block text-sm font-medium leading-none text-blue-500">
        Video File
        <button
          class="block mt-2 whitespace-no-wrap btn btn-blue"
          @click.prevent
        >
          Upload a Video
        </button>
      </label>

      <p class="mb-1 text-lg font-bold text-blue-500 whitespace-no-wrap">
        -or-
      </p>

      <InputText
        class="w-full"
        label="Video Link"
        :label-white="false"
        :bg-gray="true"
        :value="value.video.link"
        @input="$emit('input', { ...value, video: { file: value.video.file, link: $event } })"
      />
    </div>

    <button
      class="self-end btn btn-red"
      @click.prevent="$emit('remove-lesson', { sectionIndex, lessonIndex })"
    >
      - Remove this Lesson
    </button>
  </div>
</template>

<script>
import InputText from '@/components/inputs/InputText'
import InputTextArea from '@/components/inputs/InputTextArea'

export default {
  name: 'LessonForm',
  components: {
    InputText,
    InputTextArea,
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
}
</script>
