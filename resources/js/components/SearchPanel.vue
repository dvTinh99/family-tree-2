<template>
  <div class="fixed left-4 top-4 z-60 bg-white border p-2 rounded shadow flex gap-2 items-center">
    <input
      v-model="name"
      @keyup.enter="doSearch"
      placeholder="Name"
      class="px-2 py-1 border rounded w-40"
    />
    <input
      v-model="age"
      @keyup.enter="doSearch"
      type="number"
      placeholder="Age"
      class="px-2 py-1 border rounded w-20"
    />
    <button @click="doSearch" class="px-3 py-1 bg-sky-600 text-white rounded">Search</button>
    <button @click="doClear" class="px-3 py-1 border rounded">Clear</button>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'
const emit = defineEmits(['search', 'clear'])
const name = ref('')
const age = ref('')
function doSearch() {
  emit('search', { name: name.value.trim(), age: age.value.trim() })
}
function doClear() {
  name.value = ''
  age.value = ''
  emit('clear')
}

// --- INSERT SEARCH LOGIC BELOW ---
const searchName = ref('')
const searchAge = ref('')

function clearSearch() {
  searchName.value = ''
  searchAge.value = ''
  // restore default visuals
  clearSelection()
}

function performSearch() {
  const q = (searchName.value || '').trim().toLowerCase()
  const ageQ = searchAge.value ? parseInt(searchAge.value, 10) : NaN

  // find matched nodes
  const matched = familyStore.nodes.value.filter((n) => {
    const name = ((n.data && n.data.name) || n.label || '').toString().toLowerCase()
    const nameMatch = q ? name.includes(q) : true

    let ageMatch = true
    if (!Number.isNaN(ageQ)) {
      const birth = n.data?.birth
      if (!birth) ageMatch = false
      else {
        const b = new Date(birth)
        if (Number.isNaN(b.getTime())) ageMatch = false
        else {
          const age = Math.floor((Date.now() - b.getTime()) / (1000 * 60 * 60 * 24 * 365.25))
          ageMatch = age === ageQ
        }
      }
    }

    return nameMatch && ageMatch
  })

  const matchedIds = new Set(matched.map((m) => m.id))

  // highlight matched nodes
  nodes.value = nodes.value.map((n) => ({
    ...n,
    data: { ...(n.data || {}), _highlight: matchedIds.has(n.id) },
  }))

  // highlight edges that connect to matched nodes, dim others
  edges.value = edges.value.map((e) => {
    const related = matchedIds.has(e.source) || matchedIds.has(e.target)
    const copy = { ...e }
    if (related)
      copy.style = { ...(copy.style || {}), stroke: '#06b6d4', strokeWidth: 3, opacity: 1 }
    else copy.style = { ...(copy.style || {}), opacity: 0.12 }
    return copy
  })

  // clear selectedNodeId because search can select multiple
  selectedNodeId.value = null
  familyStore.setNodeSelected(null)
}
// --- END SEARCH LOGIC ---
</script>
