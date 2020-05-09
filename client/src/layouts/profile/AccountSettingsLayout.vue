<template>
  <main class="space-y-20">
    <section class="space-y-6">
      <h2 class="text-3xl font-semibold leading-tight">
        User Information
      </h2>

      <form
        class="flex flex-col w-1/2 space-y-8"
        @submit.prevent
      >
        <InputText
          v-model="user.email"
          label="Email"
          type="email"
          :bg-gray="true"
          :label-white="false"
        />

        <InputText
          v-model="user.password"
          label="Password"
          type="password"
          :bg-gray="true"
          :label-white="false"
        />

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
  data () {
    return {
      user: {
        email: 'abc123@mail.aub.edu',
        password: '********',
      },
    }
  },
}
</script>
