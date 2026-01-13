<script setup lang="ts">
defineProps<{
  x: number
  y: number
  visible: boolean
}>()

const emit = defineEmits(['select-relation'])

function choose(rel: string) {
  emit('select-relation', rel)
}
</script>

<template>
  <div
    v-if="visible"
    :style="{ top: y + 'px', left: x + 'px' }"
    class="absolute bg-white border shadow rounded-md p-2 space-y-2 z-50"
  >
    <button class="block w-full text-left px-4 py-1 hover:bg-gray-100" @click="choose('child')">
      Thêm Con
    </button>
    <button class="block w-full text-left px-4 py-1 hover:bg-gray-100" @click="choose('father')">
      Thêm Bố
    </button>
    <button class="block w-full text-left px-4 py-1 hover:bg-gray-100" @click="choose('mother')">
      Thêm Mẹ
    </button>
    <button class="block w-full text-left px-4 py-1 hover:bg-gray-100" @click="choose('spouse')">
      Thêm Chồng/Vợ
    </button>
  </div>
</template>
