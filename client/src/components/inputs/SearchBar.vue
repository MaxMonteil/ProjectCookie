<template functional>
  <input
    :ref="data.ref"
    :type="props.type"
    placeholder="Search"
    class="block w-full py-1 pl-2 text-black placeholder-gray-600 rounded outline-none transition-opacity duration-100 focus:shadow focus:opacity-100"
    :class="[
      data.class,
      data.staticClass,
      props.bgGray ? 'bg-gray-200' : 'bg-white',
      props.withOpacity ? 'opacity-50' : 'opacity-100',
    ]"
    :style="[
      data.style,
      data.staticStyle,
    ]"
    v-bind="data.attrs"
    v-on="{
      ...listeners,
      input: e => listeners.input(e.target.value),
      blur: props.withBlur ? e => listeners.input('') : () => {},
    }"
  >
</template>

<script>
export default {
  name: 'InputText',
  props: {
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
    withOpacity: {
      type: Boolean,
      default: false,
    },
    withBlur: {
      type: Boolean,
      default: true,
    },
  },
}
</script>
