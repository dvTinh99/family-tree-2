<script setup>
import { computed } from 'vue'

const props = defineProps({
  id: String,
  data: {
    type: Object,
    default: () => ({}),
  },
  selected: Boolean,
})

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
</script>

<template>
  <div
    :class="['person-node', { selected }]"
    style="
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
    <img
      :src="avatar"
      alt="avatar"
      style="width: 56px; height: 56px; border-radius: 999px; object-fit: cover"
    />
    <div style="text-align: left; flex: 1; line-height: 1">
      <div style="font-weight: 700; font-size: 14px; color: #111827">{{ name }}</div>
      <div style="font-size: 12px; color: #6b7280; margin-top: 4px">
        <span v-if="age">Age: {{ age }}</span>
        <span v-else>Age: —</span>
        <div style="font-size: 11px; color: #9ca3af; margin-top: 2px">Born: {{ birth || '—' }}</div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.person-node.selected {
  box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.18);
}
</style>
