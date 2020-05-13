<template>
  <main class="h-screen px-64 pt-24 pb-32 bg-gradient space-y-20">
    <h1 class="text-5xl font-bold leading-tight text-center text-white">
      ProjectCookie
    </h1>

    <router-view />
  </main>
</template>

<script>
export default {
  name: 'Auth',
}
</script>

<style scoped>
.bg-gradient {
  /* fallback */
  background-image: linear-gradient(155.44deg, rgb(66, 153, 225) 16.29%, rgb(42, 67, 101) 148.99%);
  background-image: linear-gradient(155.44deg, rgb(66, 153, 225) 16.29%, rgb(42, 67, 101) 148.99%), url("../../public/cookie_bg-min.jpg");
  background-blend-mode: multiply;
  background-size: cover;
}
</style>
