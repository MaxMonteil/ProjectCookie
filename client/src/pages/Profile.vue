<template>
  <main class="grid grid-cols-11 gap-8">
    <ProfileMenu
      class="h-full col-span-2"
    />
    <section class="col-span-9">
      <p v-if="loading">
        Loading...
      </p>

      <router-view
        v-else
        :user="user"
      />
    </section>
  </main>
</template>

<script>
import ProfileMenu from '@/components/ui/profile/ProfileMenu'

export default {
  name: 'Profile',
  components: {
    ProfileMenu,
  },
  data () {
    return {
      loading: true,
      user: {},
    }
  },
  created () {
    this.fetchAccount()
  },
  methods: {
    async fetchAccount () {
      const response = await fetch('../user.json')
      const user = await response.json()

      this.user = user
      this.loading = false
    },
  },
}
</script>
