<template>
  <div class="fixed left-4 top-4 z-60 bg-white border p-2 rounded shadow flex gap-2 items-center">
    <input v-model="name" @keyup.enter="doSearch" placeholder="Name" class="px-2 py-1 border rounded w-40" />
    <input v-model="age" @keyup.enter="doSearch" type="number" placeholder="Age" class="px-2 py-1 border rounded w-20" />
    <button @click="doSearch" class="px-3 py-1 bg-sky-600 text-white rounded">Search</button>
    <button @click="doClear" class="px-3 py-1 border rounded">Clear</button>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'
const emit = defineEmits(['search', 'clear'])
const name = ref('')
const age = ref('')
function doSearch() { emit('search', { name: name.value.trim(), age: age.value.trim() }) }
function doClear() { name.value = ''; age.value = ''; emit('clear') }
</script>
