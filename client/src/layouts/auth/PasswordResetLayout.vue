<template>
  <section class="flex flex-col items-center space-y-4">
    <h2 class="text-3xl font-bold text-center text-white">
      Reset Your Password
    </h2>

    <form
      v-if="!error"
      class="flex flex-col w-1/2 space-y-8"
      @submit.prevent="resetPassword"
    >
      <InputText
        v-model.trim="password"
        label="Password"
        :disabled="loading"
      />

      <InputText
        v-model.trim="passwordConfirm"
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

      <div class="text-center">
        <button
          class="self-center w-4/5 mt-20 btn btn-blue"
          :class="{
            'border-blue-200 bg-blue-200 text-blue-900 cursor-wait shadow-none': loading,
            'bg-blue-200 border-blue-200 text-blue-900 shadow-none cursor-default' : !formValid,
          }"
          :disabled="loading || !formValid"
        >
          {{
            loading
              ? 'Changing your password...'
              : formValid
                ? 'Reset my password'
                : 'All fields are required'
          }}
        </button>
      </div>
    </form>

    <div
      v-if="error"
      class="p-4 text-center bg-red-500 rounded shadow"
    >
      <p class="font-bold text-white">
        {{ error }}
      </p>
    </div>
  </section>
</template>

<script>
import InputText from '@/components/inputs/InputText'

export default {
  name: 'PasswordReset',
  components: {
    InputText,
  },
  data () {
    return {
      loading: false,
      error: '',
      success: '',
      validator: '',
      password: '',
      passwordConfirm: '',
    }
  },
  computed: {
    formValid () {
      return this.password !== '' && this.passwordConfirm !== ''
    },
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

        await this.$api.auth.resetPass({
          validator: this.validator,
          password: this.password,
          confirmpassword: this.passwordConfirm,
        })

        this.password = ''
        this.passwordConfirm = ''
      } catch (error) {
        this.error = error
      }

      this.loading = false
    },
  },
}
</script>
