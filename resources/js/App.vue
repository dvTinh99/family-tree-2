<template>
  <!-- <div class="min-h-screen bg-slate-50"> -->
  <router-view />
  <!-- </div> -->
</template>
<script setup lang="ts">
import { nextTick, onMounted } from 'vue'
import { useFamilyStore } from './store/family'

const familyStore = useFamilyStore()
function handleDocumentClick(event: MouseEvent) {
  // xem đường dẫn DOM event
  const path = event.composedPath?.() ?? []

  // nếu click không rơi vào node hoặc edge
  const clickedNodeOrEdge = path.some(
    (el) =>
      (el as HTMLElement)?.classList?.contains('vue-flow__node') ||
      (el as HTMLElement)?.classList?.contains('vue-flow__edge-path')
  )

  if (!clickedNodeOrEdge) {
    // clear selection
    familyStore.setNodeSelected(null)
  }
}

onMounted(() =>
  nextTick(() => {
    document.addEventListener('click', handleDocumentClick)
  })
)
</script>
