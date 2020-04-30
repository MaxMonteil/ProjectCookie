<template functional>
  <section class="w-56 rounded shadow space-y-1">
    <div class="rounded-t w-full h-32 bg-blue-500" />

    <article class="space-y-1 px-2 pb-1">
      <h1 class="text-lg font-bold">
        <slot />
      </h1>

      <p class="text-blue-900 text-xs">
        <slot name="start-date" />
      </p>

      <p class="text-blue-900 text-xs">
        <slot name="student-count" /> Students
      </p>

      <p class="text-blue-900 text-xs">
        <slot name="progress" />
      </p>

      <div class="flex justify-between">
        <button class="btn btn-blue-sec">
          View
        </button>

        <button class="btn btn-blue">
          Manage
        </button>
      </div>

      <p class="text-sm h-20 leading-snug overflow-hidden">
        <slot name="description" />
      </p>
    </article>
  </section>
</template>
