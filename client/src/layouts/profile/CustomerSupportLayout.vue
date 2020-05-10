<template>
  <main>
    <h1 class="mb-6 text-3xl font-semibold leading-tight">
      Customer Support
    </h1>

    <p class="mb-8">
      This is a student project, we’re making it for the course and likely not much else, feel free to send an email to this fake address, it’s likely that no one will help you but it might make you feel better!
    </p>

    <form
      class="flex flex-col space-y-6"
      @submit.prevent
    >
      <textarea
        v-model="message"
        class="block w-full p-4 bg-gray-200 rounded"
        name=""
        rows="10"
      />

      <button
        class="self-end btn btn-blue"
        type="submit"
      >
        Send Message
      </button>
    </form>
  </main>
</template>

<script>
export default {
  name: 'CustomerSupportLayout',
  data () {
    return {
      message: '',
    }
  },
}
</script>
