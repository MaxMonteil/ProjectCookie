<template>
  <section class="flex flex-col items-center space-y-4">
    <h2 class="text-3xl font-bold text-center text-white">
      Login
    </h2>

    <form
      class="flex flex-col w-1/2 space-y-8"
      @submit.prevent="loginUser"
    >
      <InputText
        v-model.trim="email"
        label="Email (must end with .edu)"
        class="flex-grow"
        type="email"
        :disabled="loading"
      />

      <div>
        <InputText
          v-model.trim="password"
          label="Password"
          :disabled="loading"
        />
        <router-link
          :to="{ name: 'forgot-password' }"
          class="inline-block mt-3 text-sm text-gray-200 underline"
          :class="{ 'cursor-default no-underline': loading }"
        >
          I forgot my password...
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
          {{ loading ? 'Logging in...' : 'Login' }}
        </button>
      </div>
    </form>
    <router-link
      :to="{ name: 'register' }"
      class="inline-block mt-3 text-sm text-gray-200 underline"
      :class="{ 'cursor-default no-underline': loading }"
      :disabled="loading"
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
      loading: false,
      email: '',
      password: '',
      error: '',
    }
  },
  methods: {
    async loginUser () {
      try {
        this.loading = true
        this.error = ''

        const response = await this.$api.auth.login({
          email: this.email,
          password: this.password,
        })

        window.localStorage.setItem(
          process.env.VUE_APP_USER_KEY,
          JSON.stringify({
            token: response.jwt,
            email: response.email,
          }),
        )

        this.loading = false
        this.$router.push({ name: 'home' })
      } catch (error) {
        this.loading = false
        this.error = error
      }
    },
  },
}
</script>
