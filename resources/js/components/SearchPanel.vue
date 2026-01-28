<template>
  <div class="bg-white border p-2 rounded shadow flex gap-2 items-center">
    <input
      v-model="name"
      @keyup.enter="performSearch"
      placeholder="Name"
      class="px-2 py-1 border rounded w-40"
    />
    <input
      v-model="age"
      @keyup.enter="performSearch"
      type="number"
      placeholder="Age"
      class="px-2 py-1 border rounded w-20"
    />
    <button @click="performSearch" class="px-3 py-1 bg-sky-600 text-white rounded">Search</button>
    <button @click="clearSearch" class="px-3 py-1 border rounded">Clear</button>
  </div>
</template>

<script setup lang="ts">
import { useFamilyStore } from '@/store/family'
import { ref } from 'vue'
const name = ref('')
const age = ref('')
const familyStore = useFamilyStore()
// --- INSERT SEARCH LOGIC BELOW ---

function clearSearch() {
  name.value = ''
  age.value = ''
  // restore default visuals
  clearSelection()
}

function performSearch() {
  const q = (name.value || '').trim().toLowerCase()
  const ageQ = age.value ? parseInt(age.value, 10) : NaN

  // find matched nodes
  const matched = familyStore.nodes.filter((n) => {
    const name = ((n.data && n.data.name) || n.label || '').toString().toLowerCase()
    const nameMatch = q ? name.includes(q) : false

    // let ageMatch = true
    // if (!Number.isNaN(ageQ)) {
    //   const birth = n.data?.birth
    //   if (!birth) ageMatch = false
    //   else {
    //     const b = new Date(birth)
    //     if (Number.isNaN(b.getTime())) ageMatch = false
    //     else {
    //       const age = Math.floor((Date.now() - b.getTime()) / (1000 * 60 * 60 * 24 * 365.25))
    //       ageMatch = age === ageQ
    //     }
    //   }
    // }

    return nameMatch
  })

  const matchedIds = new Set(matched.map((m) => m.id))

  // highlight matched nodes
  familyStore.nodes = familyStore.nodes.map((n) => ({
    ...n,
    data: { ...(n.data || {}), _highlight: matchedIds.has(n.id) },
  }))

  // highlight edges that connect to matched nodes, dim others
  // edges.value = edges.value.map((e) => {
  //   const related = matchedIds.has(e.source) || matchedIds.has(e.target)
  //   const copy = { ...e }
  //   if (related)
  //     copy.style = { ...(copy.style || {}), stroke: '#06b6d4', strokeWidth: 3, opacity: 1 }
  //   else copy.style = { ...(copy.style || {}), opacity: 0.12 }
  //   return copy
  // })

  // clear selectedNodeId because search can select multiple
  // selectedNodeId.value = null
  familyStore.setNodeSelected(null)
}

function clearSelection() {
  familyStore.setNodeSelected(null)

  // reset edge styles and node highlight marker
  familyStore.nodes = familyStore.nodes.map((n) => ({
    ...n,
    data: { ...(n.data || {}), _highlight: false },
  }))
}

// --- END SEARCH LOGIC ---
</script>
