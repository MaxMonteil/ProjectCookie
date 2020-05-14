<template functional>
  <component
    :is="injections.components.BaseClassCard"
    :course-id="props.course.id || ' '"
  >
    <template #name>
      {{ props.course.name }}
    </template>

    <div class="flex justify-between">
      <router-link
        class="text-lg font-bold text-gray-600 underline"
        :to="{ name: 'form', params: { formType: 'course' } }"
      >
        Edit
      </router-link>

      <router-link
        v-if="props.course.isDraft"
        class="text-lg font-bold text-green-500 underline"
        :to="{ name: 'form', params: { formType: 'course' } }"
      >
        Publish!
      </router-link>
    </div>
  </component>
</template>

<script>
export default {
  name: 'ManagedClassCard',
  inject: {
    components: {
      default: {
        BaseClassCard: () => import('@/components/ui/classCard/BaseClassCard'),
      },
    },
  },
  props: {
    course: {
      type: Object,
      required: true,
    },
  },
}
</script>
