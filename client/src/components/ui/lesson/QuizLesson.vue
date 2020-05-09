<template>
  <main class="space-y-16">
    <p class="pb-6 border-b-2 border-gray-200">
      {{ lesson.description }}
    </p>

    <form
      class="flex flex-col space-y-20"
      @submit.prevent
    >
      <ol class="space-y-12">
        <li
          v-for="({ question, answers }, i) in lesson.questions"
          :key="i"
        >
          <fieldset>
            <legend class="mb-4">
              <span class="font-bold">{{ i + 1 }})</span> {{ question }}
            </legend>

            <div class="space-y-6">
              <label
                v-for="(answer, j) in answers"
                :key="j"
                class="block"
              >
                <input
                  class="relative w-4 h-4 mr-1 border border-gray-600 rounded-full appearance-none transition-all ease-linear duration-75 top-1"
                  :value="answer"
                  type="radio"
                  :name="i"
                >
                {{ answer }}
              </label>
            </div>
          </fieldset>
        </li>
      </ol>

      <button class="self-end btn btn-blue">
        Submit
      </button>
    </form>
  </main>
</template>

<script>
export default {
  name: 'QuizLesson',
  props: {
    lesson: {
      type: Object,
      required: true,
    },
  },
}
</script>

<style scoped>
.top-1 {
  top: 0.125rem;
}

input:checked {
  border: 5px solid rgb(66, 153, 225);
}
</style>
