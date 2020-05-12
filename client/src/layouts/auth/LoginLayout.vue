<template>
  <section class="flex flex-col items-center space-y-4">
    <h2 class="text-3xl font-bold text-center text-white">
      Login
    </h2>

    <form class="flex flex-col w-1/2 space-y-8">
      <InputText
        v-model="email"
        label="Email (must end with .edu)"
        class="flex-grow"
      />

      <div>
        <InputText
          v-model="password"
          label="Password"
        />
        <router-link
          :to="{ name: 'forgot-password' }"
          class="inline-block mt-3 text-sm text-gray-200 underline"
        >
          I forgot my password...
        </router-link>
      </div>

      <div class="text-center">
        <button class="self-center w-4/5 mt-20 btn btn-blue">
          Login
        </button>
      </div>
    </form>
    <router-link
      :to="{ name: 'register' }"
      class="inline-block mt-3 text-sm text-gray-200 underline"
    >
      Register for an account!
    </router-link>
  </section>
</template>

<script>
import InputText from '@/components/inputs/InputText'

export default {
  name: 'Login',
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
