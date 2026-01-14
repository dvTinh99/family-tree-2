<script setup lang="ts">
import { Handle, Position } from '@vue-flow/core'
import { NodeToolbar } from '@vue-flow/node-toolbar'
import { computed } from 'vue'

const props = defineProps({
  id: String,
  data: {
    type: Object,
    default: () => ({}),
  },
  selected: Boolean,
})
const emit = defineEmits(['add-relation'])

const name = computed(() => props.data?.name || 'Unknown')
const birth = computed(() => props.data?.birth || '')
const avatar = computed(() => props.data?.avatar || 'https://i.pravatar.cc/80')
const age = computed(() => {
  if (!birth.value) return ''
  const b = new Date(birth.value)
  if (Number.isNaN(b.getTime())) return ''
  const diff = new Date().getTime() - b.getTime()
  return Math.floor(diff / (1000 * 60 * 60 * 24 * 365.25))
})

function emitAddRelation(type: string) {
  emit('add-relation', { sourceId: props.id, relationType: type })
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
    <div
      :class="['person-node', { selected }]"
      :data-highlight="props?.data?._highlight ? 'true' : 'false'"
      style="
        position: relative;
        width: 180px;
        height: 90px;
        display: flex;
        gap: 8px;
        align-items: center;
        padding: 8px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
        border-radius: 8px;
        background: #fff;
        border: 1px solid #e5e7eb;
      "
    >
      <!-- toolbar -->

      <NodeToolbar :is-visible="data.toolbarVisible" :position="Position.Top">
        <div>
          <button title="Add father" @click.stop="emitAddRelation('father')">👨</button>
          <button title="Add mother" @click.stop="emitAddRelation('mother')">👩</button>
          <button title="Add sibling" @click.stop="emitAddRelation('sibling')">🧑</button>
          <button title="Add child" @click.stop="emitAddRelation('child')">👶</button>
          <button title="Add spouse" @click.stop="emitAddRelation('spouse')">💍</button>
        </div>
      </NodeToolbar>

      <img
        :src="avatar"
        alt="avatar"
        style="width: 56px; height: 56px; border-radius: 999px; object-fit: cover"
      />
      <div style="text-align: left; flex: 1; line-height: 1">
        <div style="font-weight: 700; font-size: 14px; color: #111827">{{ name }}</div>
        <div style="font-size: 12px; color: #6b7280; margin-top: 4px">
          <span v-if="age">Age: {{ age }}</span
          ><span v-else>Age: —</span>
          <div style="font-size: 11px; color: #9ca3af; margin-top: 2px">
            Born: {{ birth || '—' }}
          </div>
        </div>
      </div>
    </div>
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
