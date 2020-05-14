<template>
  <section class="flex flex-col items-center space-y-4">
    <h2 class="text-3xl font-bold text-center text-white">
      Register
    </h2>

    <form
      class="flex flex-col w-1/2 space-y-8"
      @submit.prevent="registerUser"
    >
      <InputText
        v-model="email"
        label="Email (must end with .edu)"
        class="flex-grow"
        :disabled="loading"
      />

      <InputText
        v-model="password"
        label="Password"
        :disabled="loading"
      />

      <InputText
        v-model="passwordConfirm"
        label="Confirm Password"
        :disabled="loading"
      />

      <div
        v-if="success"
        class="p-4 text-center bg-green-500 rounded shadow"
      >
        <p class="font-bold text-white">
          Your account was successfully created! Check your email to verify your account before you can log in.
        </p>

        <router-link
          :to="{ name: 'login' }"
          class="inline-block mt-2 text-sm text-white underline"
        >
          Go to login
        </router-link>
      </div>

      <div
        v-if="error"
        class="p-4 text-center bg-red-500 rounded shadow"
      >
        <p class="font-bold text-white">
          {{ error }}
        </p>
      </div>

      <div class="text-center">
        <button
          class="self-center w-4/5 mt-20 btn btn-blue"
          :class="{ 'border-blue-200 bg-blue-200 text-blue-900 cursor-wait shadow-none': loading }"
          :disabled="loading"
        >
          {{ loading ? 'Creating your account...' : 'Register' }}
        </button>
      </div>
    </form>
    <router-link
      :to="{ name: 'login' }"
      class="inline-block mt-3 text-sm text-gray-200 underline"
      :class="{ 'cursor-default no-underline': loading }"
      :disabled="loading"
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
      loading: false,
      success: false,
      error: '',
      email: '',
      password: '',
      passwordConfirm: '',
    }
  },
  methods: {
    async registerUser () {
      try {
        this.loading = true
        this.error = ''

        await this.$api.auth.register({
          email: this.email,
          password: this.password,
          confirmpassword: this.passwordConfirm,
        })

        this.email = ''
        this.password = ''
        this.passwordConfirm = ''

        this.loading = false
        this.success = true
      } catch (error) {
        this.loading = false
        this.error = error
      }
    },
  },
}
</script>
