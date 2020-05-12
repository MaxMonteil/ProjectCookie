<template>
  <section class="flex flex-col items-center space-y-8">
    <div class="space-y-4">
      <h2 class="text-3xl font-bold text-center text-white">
        Reset My Password
      </h2>

      <p class="text-white">
        Please enter the email you used to sign up and we’ll send you a reset link with instructions.
      </p>
    </div>

    <form class="flex flex-col w-1/2 space-y-8">
      <InputText
        v-model="email"
        label="Email (must end with .edu)"
        class="flex-grow"
      />

      <div class="text-center">
        <button class="self-center w-4/5 mt-10 btn btn-blue">
          Send me a reset link
        </button>
      </div>
    </form>

    <div class="flex space-x-8">
      <router-link
        :to="{ name: 'login' }"
        class="inline-block mt-3 text-gray-200 underline"
      >
        Login
      </router-link>

      <router-link
        :to="{ name: 'register' }"
        class="inline-block mt-3 text-gray-200 underline"
      >
        Register
      </router-link>
    </div>
  </section>
</template>

<script>
import InputText from '@/components/inputs/InputText'

export default {
  name: 'ForgotPassword',
  components: {
    InputText,
  },
  data () {
    return {
      email: '',
      password: '',
    }
  },
}
</script>
