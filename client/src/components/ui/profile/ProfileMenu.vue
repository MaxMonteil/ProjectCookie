<template>
  <aside class="flex flex-col justify-between h-screen pr-8 border-r-2 border-gray-200">
    <ul class="space-y-3">
      <li
        v-for="menu in menus"
        :key="menu.name"
        class="rounded transition-all duration-200 hover:bg-blue-200"
        :class="$route.name === menu.to.name
          ? 'w-full py-2 text-lg text-center text-blue-900 bg-blue-200'
          : 'py-2 pl-2 text-gray-600'
        "
      >
        <router-link
          :to="menu.to"
        >
          {{ menu.name }}
        </router-link>
      </li>
    </ul>

    <button
      class="btn btn-blue"
      @click="logout"
    >
      Logout
    </button>
  </aside>
</template>

<script>
export default {
  name: 'ProfileMenu',
  data () {
    return {
      menus: [
        {
          name: 'My Courses',
          to: { name: 'my-courses' },
        },
        {
          name: 'Teacher\'s Center',
          to: { name: 'teachers-center' },
        },
        {
          name: 'Account Settings',
          to: { name: 'account-settings' },
        },
        {
          name: 'Customer Support',
          to: { name: 'customer-support' },
        },
      ],
    }
  },
  methods: {
    logout () {
      window.localStorage.removeItem(process.env.VUE_APP_USER_KEY)
      this.$router.push({ name: 'home' })
    },
  },
}
</script>
