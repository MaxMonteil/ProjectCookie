<template functional>
  <label
    class="text-sm leading-none font-medium"
    :class="props.labelWhite ? 'text-white' : 'text-blue-500'"
  >
    {{ props.label }}
    <input
      :ref="data.ref"
      :type="props.type"
      class="block mt-2 rounded text-lg text-black pl-2 py-1 w-full outline-none focus:shadow"
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
    >
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
  },
}
</script>
