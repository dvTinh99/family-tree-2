<script setup lang="ts">
import { Handle, Position } from '@vue-flow/core'
import { NodeToolbar } from '@vue-flow/node-toolbar'
import { computed, ref } from 'vue'
import FamilyIcon from '@/assets/svgs/family.svg'

const props = defineProps({
  id: String,
  label: String,
  data: {
    type: Object,
    default: () => ({}),
  },
  selected: Boolean,
})
const emit = defineEmits(['add-relation', 'toggle-branch'])

const name = computed(() => props.id || props.label || 'Unknown')
const birth = computed(() => props.data?.birth || '')
const avatar = computed(() => props.data?.avatar || 'https://i.pravatar.cc/80')
const age = computed(() => {
  if (!birth.value) return ''
  const b = new Date(birth.value)
  if (Number.isNaN(b.getTime())) return ''
  const diff = new Date().getTime() - b.getTime()
  return Math.floor(diff / (1000 * 60 * 60 * 24 * 365.25))
})

const toolbarAction = ref([
  {
    title: 'something',
    text: 'ᐩ',
    action: () => emitAddRelation('father'),
  },
])

function emitAddRelation(type: string) {
  emit('add-relation', { sourceId: props.id, relationType: type })
}

function emitToggleBranch() {
  emit('toggle-branch', { sourceId: props.id })
}
</script>

<template>
  <div>
    <!-- Handles (one source + one target per side) -->
    <Handle type="target" :position="Position.Top" id="top-target" />
    <Handle type="source" :position="Position.Top" id="top-source" />

    <Handle type="target" :position="Position.Bottom" id="bottom-target" />
    <Handle type="source" :position="Position.Bottom" id="bottom-source" />

    <Handle type="target" :position="Position.Left" id="left-target" />
    <Handle type="source" :position="Position.Left" id="left-source" />

    <Handle type="target" :position="Position.Right" id="right-target" />
    <Handle type="source" :position="Position.Right" id="right-source" />

    <!-- ...existing markup (avatar, toolbar, text) ... -->
     <FamilyIcon class="w-[30px] h-[30px]"/>
  </div>
</template>

<style scoped>
.person-node.selected {
  box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.18);
}

.person-node[data-highlight='true'] {
  box-shadow: 0 0 0 4px rgba(245, 158, 11, 0.18);
  transform: translateY(-2px);
  transition:
    box-shadow 0.12s ease,
    transform 0.12s ease;
}
</style>
