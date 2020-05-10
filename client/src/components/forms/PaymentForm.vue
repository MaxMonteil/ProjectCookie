<template>
  <form
    @submit.prevent="$emit('close')"
  >
    <div class="space-y-6">
      <InputText
        v-model="paymentInfo.name"
        label="Cardholder Name"
        :bg-gray="true"
        :label-white="false"
      />

      <div class="flex space-x-4">
        <div class="flex-grow">
          <InputText
            v-model="paymentInfo.card"
            class="flex-grow"
            label="Card Number"
            :bg-gray="true"
            :label-white="false"
          />
        </div>

        <div class="w-1/3">
          <InputText
            v-model="paymentInfo.expiration"
            label="Expiration Date"
            :bg-gray="true"
            :label-white="false"
          />
        </div>
      </div>

      <div class="w-1/5">
        <InputText
          v-model="paymentInfo.cvc"
          label="CVC"
          :bg-gray="true"
          :label-white="false"
        />
      </div>
    </div>

    <slot />
  </form>
</template>

<script>
import InputText from '@/components/inputs/InputText'

export default {
  name: 'PaymentForm',
  components: {
    InputText,
  },
  data () {
    return {
      paymentInfo: {
        name: '',
        card: '',
        expiration: '',
        cvc: '',
      },
    }
  },
}
</script>
