<script setup>
import { computed } from 'vue'

const props = defineProps({
  data: {
    type: Object,
    required: true
  },
  selected: Boolean
})

const genderClass = computed(() => {
  if (props.data.gender === 'male') {
    return 'ring-blue-400'
  }
  if (props.data.gender === 'female') {
    return 'ring-pink-400'
  }
  return 'ring-gray-300'
})
</script>

<template>
  <div
    class="group relative w-[180px] rounded-2xl bg-white border border-gray-200 shadow-sm
           transition-all duration-200 ease-out
           hover:shadow-md"
    :class="selected ? 'ring-2 ring-indigo-500' : ''"
  >
    <!-- Avatar -->
    <div class="flex justify-center pt-4">
      <div
        class="h-12 w-12 rounded-full bg-gray-100 ring-2"
        :class="genderClass"
      >
        <img
          v-if="data.avatar"
          :src="data.avatar"
          class="h-full w-full rounded-full object-cover"
        />
      </div>
    </div>

    <!-- Info -->
    <div class="px-4 pb-4 pt-2 text-center">
      <div class="text-sm font-semibold text-gray-900 leading-tight">
        {{ data.name }}
      </div>

      <div class="mt-0.5 text-xs text-gray-500">
        {{ data.birth }}
        <span v-if="data.death"> – {{ data.death }}</span>
      </div>
    </div>

    <!-- Hover actions (ẩn mặc định) -->
    <div
      class="absolute inset-x-0 bottom-2 flex justify-center gap-2
             opacity-0 group-hover:opacity-100 transition-opacity"
    >
      <button
        class="rounded-full bg-white p-1 shadow border text-gray-600 hover:text-indigo-600"
        title="Add child"
      >
        +
      </button>
    </div>
  </div>
</template>
