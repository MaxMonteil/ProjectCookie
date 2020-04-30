<template functional>
  <input
    :ref="data.ref"
    :type="props.type"
    placeholder="Search"
    class="block rounded text-black placeholder-blue-500 opacity-50 transition-opacity duration-100 pl-2 py-1 w-full outline-none focus:shadow focus:opacity-100"
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
    v-on="{
      ...listeners,
      input: e => listeners.input(e.target.value),
      blur: e => listeners.input(''),
    }"
  >
</template>

<script>
export default {
  name: 'InputText',
  props: {
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
