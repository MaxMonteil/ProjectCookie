<template>
  <section class="flex flex-col items-center space-y-4">
    <h2 class="text-3xl font-bold text-center text-white">
      Register
    </h2>

    <form class="flex flex-col w-1/2 space-y-8">
      <InputText
        v-model="email"
        label="Email (must end with .edu)"
        class="flex-grow"
      />

      <InputText
        v-model="password"
        label="Password"
      />

      <InputText
        v-model="passwordConfirm"
        label="Confirm Password"
      />

      <div class="text-center">
        <button class="self-center w-4/5 mt-20 btn btn-blue">
          Register
        </button>
      </div>
    </form>
    <router-link
      :to="{ name: 'login' }"
      class="inline-block mt-3 text-sm text-gray-200 underline"
    >
      I already have an account. <span class="text-bold">Log In</span>
    </router-link>
  </section>
</template>

<script>
import InputText from '@/components/inputs/InputText'

export default {
  name: 'Register',
  components: {
    InputText,
  },
  data () {
    return {
      email: '',
      password: '',
      passwordConfirm: '',
    }
  },
}
</script>
