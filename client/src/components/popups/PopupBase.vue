<template>
  <div
    role="dialog"
    :aria-label="label"
    aria-modal="true"
    class="fixed inset-0"
    :class="centered ? 'flex justify-center items-center' : ''"
  >
    <div
      v-if="!fullscreen"
      class="absolute w-full h-full -z-10"
      @click="$emit('close')"
    >
      <slot name="backdrop" />
    </div>
    <slot />
  </div>
</template>

<script>
// Component sourced from Mark Oberlehner
// https://markus.oberlehner.net/blog/popup-overlays-with-vue-router-and-portal-vue/

export default {
  name: 'PopupBase',
  props: {
    centered: {
      type: Boolean,
      default: true,
    },
    fullscreen: {
      type: Boolean,
      default: false,
    },
    focusElement: {
      type: Object,
      default: null,
    },
    label: {
      type: String,
      required: true,
    },
  },
  mounted () {
    const close = (e) => {
      const ESC = 27
      if (e.keyCode !== ESC) return
      this.$emit('close')
    }
    // Close the modal when the
    // user presses the ESC key.
    document.addEventListener('keyup', close)
    this.$on('hook:destroyed', () => {
      document.removeEventListener('keyup', close)
    })

    // Activate the modal when the component is mounted.
    this.activate()
    this.$on('hook:destroyed', () => {
      // Deactivate when the component is destroyed.
      this.deactivate()
    })
  },
  methods: {
    activate () {
      // Save the current active element
      // so we can restore it when closing
      // the popup overlay.
      this.previousActiveElement = document.activeElement

      // Prevent the background to be scrollable.
      this.disableScrolling()
      // Make it impossible to focus elements in
      // the background when using the TAB key.
      this.inert()
      // Focus the first focusable element in the dialog.
      this.focusFirstDescendant()
    },
    async deactivate () {
      this.enableScrolling()
      await this.inert(false)
      this.restoreFocus()
    },
    // Disable scrolling on all devices (including iOS).
    disableScrolling () {
      this.scrollPosition = window.pageYOffset

      const $body = document.querySelector('body')
      $body.style.overflow = 'hidden'
      $body.style.position = 'fixed'
      $body.style.top = `-${this.scrollPosition}px`
      $body.style.width = '100%'
    },
    enableScrolling () {
      const $body = document.querySelector('body')
      $body.style.removeProperty('overflow')
      $body.style.removeProperty('position')
      $body.style.removeProperty('top')
      $body.style.removeProperty('width')

      window.scrollTo(0, this.scrollPosition)
    },
    // Make all elements except the overlay inert.
    async inert (status = true) {
      await this.$nextTick();
      [...this.$root.$el.children].forEach((child) => {
        if (child === this.$el || child.contains(this.$el)) return
        child.inert = status
      })
    },
    focusFirstDescendant (element) {
      const focusable = this.$el.querySelectorAll('button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])')
      if (focusable[0] && focusable[0].focus) focusable[0].focus()
    },
    restoreFocus () {
      const element = this.focusElement || this.previousActiveElement

      if (element && element.focus) element.focus()
    },
  },
}
</script>

<style scoped>
.-z-10 {
  z-index: -10;
}
</style>
