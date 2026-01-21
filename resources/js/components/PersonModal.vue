<script setup lang="ts">
import { useFamilyTreeStore } from '@/store/familyTree'
import { ref, watch, toRefs } from 'vue'
const emit = defineEmits(['confirm', 'cancel'])

const person = ref({
  relationType: '',
  name: '',
  birth: '',
  avatar: '',
  type: 'person'
})
const familyStore = useFamilyTreeStore()

function doConfirm() {
  addNodeAndRelation(person.value.relationType)
}

function addNodeAndRelation(relation: string) {
  switch (relation) {
    case 'child':
      familyStore.addChild(person.value)
      break
    case 'mother':
      return 'child'
    case 'spouse':
      familyStore.addSpouse(person.value)
      break
    case 'sibling':
      return 'sibling'
    default:
      return 'parent'
  }
}


function doCancel() {
  emit('cancel')
}
</script>

<template>
  <div class="fixed inset-0 z-40 flex">
    <!-- sidebar panel -->
    <aside class="w-80 h-full bg-white rounded-l-lg shadow-lg p-4 overflow-auto">
      <div class="flex items-center justify-between mb-3">
        <h3 class="text-sm font-semibold">
          Add {{ person?.relationType ? person.relationType : 'Person' }}
        </h3>
        <button @click="doCancel" class="text-gray-500 hover:text-gray-700">✕</button>
      </div>

      <label class="block text-xs text-gray-600">Relation</label>
      <select v-model="person.relationType" class="w-full px-2 py-2 border rounded-md mb-2 text-sm">
        <option value="">Select relation</option>
        <option value="father">Father</option>
        <option value="mother">Mother</option>
        <option value="child">Child</option>
        <option value="spouse">Spouse</option>
        <option value="sibling">Sibling</option>
      </select>

      <label class="block text-xs text-gray-600">Name</label>
      <input
        v-model="person.name"
        class="w-full px-2 py-2 border rounded-md mb-2 text-sm"
        type="text"
      />

      <label class="block text-xs text-gray-600">Birth</label>
      <input
        v-model="person.birth"
        class="w-full px-2 py-2 border rounded-md mb-2 text-sm"
        type="date"
      />

      <label class="block text-xs text-gray-600">Avatar URL</label>
      <input
        v-model="person.avatar"
        class="w-full px-2 py-2 border rounded-md mb-3 text-sm"
        type="text"
      />

      <div class="flex justify-end gap-2 mt-4">
        <button @click="doCancel" class="px-3 py-1 text-sm rounded-md border">Cancel</button>
        <button @click="doConfirm" class="px-3 py-1 text-sm rounded-md bg-sky-600 text-white">
          Add
        </button>
      </div>
    </aside>
  </div>
</template>

<style scoped>
/* no additional styles; using Tailwind classes */
</style>
