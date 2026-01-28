<script setup lang="ts">
import { defineProps, defineEmits, ref } from 'vue'

const props = defineProps({
  relation: String,
  parentId: String,
})

const emit = defineEmits(['submit', 'close'])

const form = ref({
  name: '',
  birth: '',
  death: '',
})

function onSubmit() {
  emit('submit', {
    name: form.value.name,
    birth: form.value.birth,
    death: form.value.death,
  })
}
</script>

<template>
  <div class="fixed inset-0 bg-black bg-opacity-30 flex items-center justify-center">
    <div class="bg-white p-4 rounded shadow-lg w-80">
      <h3 class="text-lg font-semibold mb-3">Thêm {{ props.relation }}</h3>
      <input v-model="form.name" placeholder="Tên" class="border p-2 w-full mb-2" />
      <input v-model="form.birth" placeholder="Năm sinh" class="border p-2 w-full mb-2" />
      <input v-model="form.death" placeholder="Năm mất" class="border p-2 w-full mb-2" />
      <div class="text-right space-x-2">
        <button @click="emit('close')" class="px-3 py-1 border rounded">Hủy</button>
        <button @click="onSubmit" class="px-3 py-1 bg-blue-500 text-white rounded">Tạo</button>
      </div>
    </div>
  </div>
</template>
