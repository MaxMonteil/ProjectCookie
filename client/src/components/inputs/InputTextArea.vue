<template functional>
  <label
    class="block font-medium leading-none"
    :class="[
      data.class,
      data.staticClass,
      props.labelWhite ? 'text-white' : 'text-blue-500',
    ]"
  >
    {{ props.label }}
    <textarea
      :ref="data.ref"
      :type="props.type"
      :rows="props.rows"
      class="block w-full px-3 py-2 mt-2 text-lg text-black rounded outline-none focus:shadow"
      :class="[
        data.class,
        data.staticClass,
        props.bgGray ? 'bg-gray-200' : 'bg-white'
      ]"
      :style="[
        data.style,
        data.staticStyle,
      ]"
      v-bind="data.attrs"
      v-on="{ ...listeners, input: e => listeners.input(e.target.value) }"
    />
  </label>
</template>

<script>
export default {
  name: 'InputText',
  props: {
    label: {
      type: String,
      required: true,
    },
    labelWhite: {
      type: Boolean,
      default: true,
    },
    type: {
      type: String,
      default: 'text',
      validator (type) {
        return ['text', 'email', 'password'].includes(type)
      },
    },
    fontNormal: {
      type: Boolean,
      default: false,
    },
    bgGray: {
      type: Boolean,
      default: false,
    },
    rows: {
      type: [String, Number],
      default: 10,
    },
  },
}
</script>
