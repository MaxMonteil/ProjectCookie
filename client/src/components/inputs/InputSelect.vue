<template functional>
  <label
    class="font-medium inline"
    :class="[
      props.labelBlack ? 'text-black': 'text-blue-500',
    ]"
  >
    {{ props.label }}
    <select
      :ref="data.ref"
      class="capitalize select bg-no-repeat block mt-2 pl-3 pr-6 py-1 bg-gray-200 rounded text-black outline-none focus:shadow"
      :class="[
        data.class,
        data.staticClass,
        props.labelInline ? 'inline ml-2' : '',
      ]"
      :style="[
        data.style,
        data.staticStyle,
      ]"
      v-bind="data.attrs"
      v-on="{ ...listeners, input: e => listeners.input(e.target.value) }"
    >
      <option value="">
        -
      </option>
      <option
        v-for="option in props.values"
        :key="option.value || option"
        :value="option.value || option"
      >
        <slot :option="option">
          {{ option.value || option }}
        </slot>
      </option>
    </select>
  </label>
</template>

<script>
export default {
  name: 'InputSelect',
  props: {
    label: {
      type: String,
      required: true,
    },
    labelBlack: {
      type: Boolean,
      default: false,
    },
    labelInline: {
      type: Boolean,
      default: false,
    },
    values: {
      type: [Array, Object],
      required: true,
    },
  },
}
</script>

<style scoped>
.select {
  -moz-appearance: none;
  -webkit-appearance: none;
  appearance: none;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='9' viewbox='0 0 10 9' %3E%3Cpath fill='%23718096' d='M5.86603 8C5.48113 8.66667 4.51887 8.66667 4.13397 8L0.669873 2C0.284972 1.33333 0.766098 0.500001 1.5359 0.500001L8.4641 0.5C9.2339 0.5 9.71503 1.33333 9.33013 2L5.86603 8Z'/%3E%3C/svg%3E");
  background-origin: border-box;
  background-position: top 50% right 0.5rem;
}
</style>
