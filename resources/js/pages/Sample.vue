<script setup>
import { h, onMounted, ref, nextTick } from 'vue'
import { Background } from '@vue-flow/background'
import { MarkerType, Panel, useVueFlow, VueFlow } from '@vue-flow/core'
import PersonNode from '@/components/nodes/PersonNode.vue'
import { familyTreeLayout } from '@/utils/familyTreeLayout'

const isLoading = ref(true)
const nodes = ref([
  {
    id: '1',
    type: 'person',
    label: 'Parent A',
    // position: { x: 0, y: 0 },
    data: { name: 'Parent A' },
  },
  {
    id: '2',
    type: 'person',
    label: 'Parent B',
    // position: { x: 200, y: 0 },
    data: { name: 'Parent B' },
  },
  { id: '3', type: 'person', label: 'Child', data: { name: 'Child' } },
  { id: '4', type: 'person', label: 'grandfather', data: { name: 'grandfather' } },
  { id: '5', type: 'person', label: 'grandmother', data: { name: 'grandmotherr' } },
])
const edges = ref([
  {
    id: 'e1',
    source: '1',
    target: '2',
    type: 'step',
    data: { relation: 'spouse' },
    sourceHandle: 'right-source',
    targetHandle: 'left-target',
  },
  {
    id: 'e2',
    source: '1',
    target: '3',
    type: 'step',
    data: { relation: 'parent' },
    sourceHandle: 'bottom-source',
    targetHandle: 'top-target',
  },
  {
    id: 'e3',
    source: '2',
    target: '3',
    type: 'step',
    data: { relation: 'parent' },
    sourceHandle: 'bottom-source',
    targetHandle: 'top-target',
  },
  {
    id: 'e4',
    source: '4',
    target: '1',
    type: 'step',
    data: { relation: 'parent' },
    sourceHandle: 'bottom-source',
    targetHandle: 'top-target',
  },
  {
    id: 'e5',
    source: '5',
    target: '1',
    type: 'step',
    data: { relation: 'parent' },
    sourceHandle: 'bottom-source',
    targetHandle: 'top-target',
  },

])

const { fitView } = useVueFlow()
async function layoutGraph(direction) {
nodes.value = familyTreeLayout(nodes.value, edges.value)

  console.log('node ne', nodes.value)
  console.log('edges ne', edges.value)


  nextTick(() => {
    fitView()
  })
  isLoading.value = false
}

function reWritePosition(layoutedNodes) {
  console.log('layoutedNodes', layoutedNodes)

  // sau khi Dagre layout xong:
  const positionedNodes = layoutedNodes.map((n) => ({ ...n }))

  // tìm tất cả các cặp bố mẹ
  const couples = relations
    .filter((r) => r.type === 'spouse')
    .map((r) => [r.sourceId.toString(), r.targetId.toString()])

  for (const [father, mother] of couples) {
    const fatherNode = positionedNodes.find((n) => n.id === father)
    const motherNode = positionedNodes.find((n) => n.id === mother)

    // gán gap bố mẹ 100px
    if (fatherNode && motherNode) {
      const desiredGap = 100
      const midpoint = (fatherNode.position.x + motherNode.position.x) / 2

      // force gap
      const dist = Math.abs(fatherNode.position.x - motherNode.position.x)
      if (dist < desiredGap) {
        const left = midpoint - desiredGap / 2
        fatherNode.position.x = left
        motherNode.position.x = left + desiredGap
      }

      // đặt con nếu chỉ có 1 con
      const children = relations
        .filter((r) => r.parentId === Number(father) && r.type === 'parent')
        .map((r2) => r2.childId.toString())
        .filter((c) =>
          relations.some((rr) => rr.parentId === Number(mother) && rr.childId.toString() === c)
        )

      for (const childId of children) {
        const childNode = positionedNodes.find((n) => n.id === childId)
        if (childNode) {
          childNode.position.x = midpoint - (childNode.width || 0) / 2
        }
      }
    }
  }

  return positionedNodes
}

onMounted(() => nextTick(() => layoutGraph('TB')))
</script>

<template>
  <div class="h-screen w-screen" v-if="!isLoading">
    {{ nodes }}
    <VueFlow :nodes="nodes" :edges="edges">
      <template #node-person>
        <PersonNode />
      </template>
      <template #node-marriage>
        <div class="h-1 w-1 opacity-0">maried</div>
      </template>
      <Background />

      <Panel class="process-panel" position="top-right">
        <div class="layout-panel">
          <button title="set horizontal layout" @click="layoutGraph('LR')">Horizon</button>

          <button title="set vertical layout" @click="layoutGraph('TB')">vertical</button>
        </div>
      </Panel>
    </VueFlow>
  </div>
</template>
