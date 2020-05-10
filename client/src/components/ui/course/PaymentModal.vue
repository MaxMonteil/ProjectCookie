<template>
  <PopupBase
    label="payment modal"
    @close="$emit('close')"
  >
    <template #backdrop>
      <div class="absolute w-full h-full bg-black bg-opacity-25" />
    </template>

    <div class="px-16 py-12 bg-white rounded shadow-lg space-y-6">
      <header class="text-center">
        <h2 class="mb-8 text-lg font-bold text-blue-500">
          You are about to enroll into this course
        </h2>

        <h1 class="mb-2 text-3xl font-semibold leading-tight">
          {{ course.name }}
        </h1>

        <div class="flex justify-center mb-12 rounded space-x-2 divide-x-2 divide-gray-200">
          <span class="flex items-center">
            <div class="w-6 h-6 p-2 mr-2 bg-blue-900 rounded-full" />
            <p>{{ course.teacher }}</p>
          </span>
          <p class="pl-2 text-gray-600">
            {{ course.startDate }}
          </p>
          <p class="pl-2 text-gray-600">
            {{ course.studentCount }} Students
          </p>
        </div>

        <h2 class="flex justify-between pb-6 text-2xl font-bold border-b border-gray-200">
          <span class="text-gray-600">Total Price:</span>
          <span class="text-blue-500">{{ course.price }}$</span>
        </h2>
      </header>

      <PaymentForm>
        <div class="mt-20 text-center space-x-6">
          <button class="btn btn-blue-sec">
            Enroll
          </button>

          <button class="btn btn-blue">
            Save payment details and Enroll
          </button>
        </div>
      </PaymentForm>
    </div>
  </PopupBase>
</template>

<script>
import PopupBase from '@/components/popups/PopupBase'
import PaymentForm from '@/components/forms/PaymentForm'

export default {
  name: 'PaymentModal',
  components: {
    PopupBase,
    PaymentForm,
  },
  props: {
    course: {
      type: Object,
      required: true,
    },
  },
}
</script>
