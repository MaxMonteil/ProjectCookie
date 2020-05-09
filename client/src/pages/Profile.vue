<template>
  <main class="grid grid-cols-11 gap-8">
    <ProfileMenu
      class="h-full col-span-2"
    />
    <section class="col-span-9">
      <router-view />
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
}
</script>
