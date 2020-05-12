<template>
  <main class="space-y-20">
    <section class="space-y-6">
      <h2 class="text-3xl font-semibold leading-tight">
        User Information
      </h2>

      <InputText
        v-model="email"
        class="w-1/2 text-gray-600"
        label="Email"
        type="email"
        :bg-gray="true"
        :label-white="false"
        disabled
      />

      <form
        class="flex flex-col w-1/2 space-y-8"
        @submit.prevent
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
        />

        <InputText
          v-model="password.new"
          label="New password"
          type="password"
          :bg-gray="true"
          :label-white="false"
        />

        <InputText
          v-model="password.confirm"
          label="Confirm new password"
          type="password"
          :bg-gray="true"
          :label-white="false"
        />

        <button
          class="self-end btn btn-blue"
          type="submit"
        >
          Change Password
        </button>

        <button
          class="btn btn-red"
          type="submit"
        >
          Delete my account
        </button>
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
      email: this.user.email,
      password: {
        current: '',
        new: '',
        confirm: '',
      },
    }
  },
}
</script>
