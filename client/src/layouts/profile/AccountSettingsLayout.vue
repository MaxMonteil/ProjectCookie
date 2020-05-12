<template>
  <main class="space-y-20">
    <section class="space-y-6">
      <h2 class="text-3xl font-semibold leading-tight">
        User Information
      </h2>

      <InputText
        v-model="email"
        class="w-1/2"
        label="Email"
        type="email"
        :label-white="false"
        :disabled="true"
      />

      <form
        class="flex flex-col w-1/2 space-y-8"
        @submit.prevent="changePass"
      >
        <h3 class="text-lg font-bold text-gray-600">
          Change Password
        </h3>

        <InputText
          v-model="password.current"
          label="Current password"
          type="password"
          :bg-gray="true"
          :label-white="false"
          :disabled="loading"
        />

        <InputText
          v-model="password.new"
          label="New password"
          type="password"
          :bg-gray="true"
          :label-white="false"
          :disabled="loading"
        />

        <InputText
          v-model="password.confirm"
          label="Confirm new password"
          type="password"
          :bg-gray="true"
          :label-white="false"
          :disabled="loading"
        />

        <button
          class="self-end btn btn-blue"
          :class="{ 'bg-blue-200 border-blue-200 text-blue-900 cursor-wait' : loading }"
          type="submit"
          :disabled="loading"
        >
          Change Password
        </button>

        <div
          v-if="error"
          class="p-4 text-center bg-red-500 rounded shadow"
        >
          <p class="font-bold text-white">
            {{ error }}
          </p>
        </div>

        <div
          v-if="sucess"
          class="p-4 text-center bg-green-500 rounded shadow"
        >
          <p class="font-bold text-white">
            Your password has been changed.
          </p>
        </div>
      </form>
    </section>

    <section class="space-y-6">
      <h2 class="text-3xl font-semibold leading-tight">
        Billing Information
      </h2>

      <PaymentForm class="w-1/2">
        <div class="flex flex-col mt-6 space-y-6">
          <button
            class="self-end btn btn-blue"
            type="submit"
          >
            Save Changes
          </button>
          <button
            class="self-end btn btn-red"
            type="submit"
          >
            Delete my billing information
          </button>
        </div>
      </PaymentForm>
    </section>
  </main>
</template>

<script>
import InputText from '@/components/inputs/InputText'
import PaymentForm from '@/components/forms/PaymentForm'

export default {
  name: 'AccountSettingsLayout',
  components: {
    InputText,
    PaymentForm,
  },
  props: {
    user: {
      type: Object,
      required: true,
    },
  },
  data () {
    return {
      loading: false,
      sucess: true,
      message: '',
      error: '',
      email: '',
      password: {
        current: '',
        new: '',
        confirm: '',
      },
    }
  },
  mounted () {
    const id = setTimeout(() => {
      clearTimeout(id)
      this.sucess = false
    }, 3000)
  },
  methods: {
    async changePass () {
      try {
        this.loading = true
        this.error = ''

        await this.$api.changePass({
          email: this.email,
          oldpassword: this.password.current,
          newpassword: this.password.new,
          confirmnewpassword: this.password.confirm,
        })

        this.loading = false
        this.sucess = true
        const id = setTimeout(() => {
          clearTimeout(id)
          this.sucess = false
        }, 3000)
      } catch (error) {
        this.loading = false
        this.error = error.message
      }
    },
  },
}
</script>
