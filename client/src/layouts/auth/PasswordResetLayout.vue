<template>
  <section class="flex flex-col items-center space-y-4">
    <h2 class="text-3xl font-bold text-center text-white">
      Reset Your Password
    </h2>

    <form
      class="flex flex-col w-1/2 space-y-8"
      @submit.prevent="resetPassword"
    >
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
          Your password was successfully changed!
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
          {{ loading ? 'Changing your password' : 'Confirm Password Reset' }}
        </button>
      </div>
    </form>
  </section>
</template>

<script>
export default {
  name: 'PasswordReset',
  data () {
    return {
      loading: true,
      error: '',
      validator: '',
      password: '',
      passwordConfirm: '',
    }
  },
  mounted () {
    this.resetPassword()
  },
  methods: {
    async resetPassword () {
      try {
        this.loading = true
        this.error = ''

        const validator = this.$route.query.validator
        if (!validator) {
          throw new Error('Invalid password reset link')
        }

        await this.$api.auth.resetPassword({
          validator: this.validator,
          password: this.password,
          confirmpassword: this.passwordConfirm,
        })

        this.loading = false
      } catch (error) {
        this.loading = false
        this.error = error
      }
    },
  },
}
</script>
