<template>
  <section class="flex flex-col items-center space-y-4">
    <h2
      v-if="!error"
      class="text-3xl font-bold text-center text-white"
    >
      {{ loading ? 'Verifying your acount...' : 'Your account has been verified!' }}
    </h2>
    <h2
      v-else
      class="text-3xl font-bold text-center text-white"
    >
      Unable to verify your account.
    </h2>

    <div
      v-if="error"
      class="p-4 text-center bg-red-500 rounded shadow"
    >
      <p class="font-bold text-white">
        {{ error }}
      </p>
    </div>

    <p
      v-if="!loading && !error"
      class="text-white"
    >
      You may now login
    </p>

    <router-link
      v-if="!loading && !error"
      :to="{ name: 'login' }"
      class="inline-block mt-3 text-gray-200 underline"
    >
      Go to Login
    </router-link>
  </section>
</template>

<script>
export default {
  name: 'Verify',
  data () {
    return {
      loading: true,
      error: '',
    }
  },
  mounted () {
    this.verifyAccount()
  },
  methods: {
    async verifyAccount () {
      try {
        this.loading = true
        this.error = ''

        const token = encodeURIComponent(new URLSearchParams(window.location.search.substring(1)).get('hash'))
        const email = this.$route.query.email
        if (!token || !email) {
          throw new Error('Invalid verification link')
        }

        await this.$api.auth.verify({ token, email })
      } catch (error) {
        if (error === 'OK') return

        this.error = error
      }

      this.loading = false
    },
  },
}
</script>
