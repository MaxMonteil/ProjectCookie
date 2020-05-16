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

    <form
      v-if="!error"
      class="flex flex-col w-1/2 space-y-8"
      @submit.prevent="sendRecoveryEmail"
    >
      <InputText
        v-model.trim="email"
        label="Email (must end with .edu)"
        class="flex-grow"
      />

      <div class="text-center">
        <button
          class="self-center w-4/5 mt-10 btn btn-blue"
          :class="{
            'border-blue-200 bg-blue-200 text-blue-900 cursor-wait shadow-none': loading,
            'bg-blue-200 border-blue-200 text-blue-900 shadow-none cursor-default' : !formValid,
          }"
          :disabled="loading || !formValid"
        >
          {{
            loading
              ? 'Sending you a recovery email...'
              : formValid
                ? 'Send me a reset link'
                : 'Email is required'
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
      loading: false,
      error: '',
      email: '',
    }
  },
  computed: {
    formValid () {
      return this.email !== ''
    },
  },
  methods: {
    async sendRecoveryEmail () {
      try {
        this.loading = true
        this.error = ''

        await this.$api.auth.sendPassReset({
          email: this.email,
        })
      } catch (error) {
        this.error = error
      }

      this.loading = false
    },
  },
}
</script>
