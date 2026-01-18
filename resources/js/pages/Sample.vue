<script setup lang="ts">
import { h, onMounted, ref, nextTick } from 'vue'
import { Background } from '@vue-flow/background'
import { Edge, MarkerType, Node, Panel, useVueFlow, VueFlow } from '@vue-flow/core'
import PersonNode from '@/components/nodes/PersonNode.vue'
import { familyTreeLayout2, addSpouseAndRerouteParents } from '@/utils/familyTreeLayout'
import SpouseNode from '@/components/nodes/SpouseNode.vue'

const isLoading = ref(true)
const nodes = ref<any[]>([
  {
    id: '1',
    type: 'person',
    label: 'Parent A',
    data: { name: 'Parent A' },
  },
  {
    id: '2',
    type: 'person',
    label: 'Parent B',
    data: { name: 'Parent B' },
  },
  {
    id: '3',
    type: 'person',
    data: {}
  },
])
const edges = ref<Edge[]>([
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
  
])

const { fitView } = useVueFlow()
async function layoutGraph(direction) {
  const { nodes: nodesFormat, edges: edgesFormat} = addSpouseAndRerouteParents(nodes.value, edges.value)

  nodes.value = familyTreeLayout2(nodesFormat, edgesFormat)
  // nodes.value = nodeGraph
  edges.value = edgesFormat

  console.log('nodes', nodes.value);
  console.log('edges', edges.value);
  
  

  nextTick(() => {
    fitView()
  })
  isLoading.value = false
}

onMounted(() => nextTick(() => layoutGraph('TB')))
</script>

<template>
  <div class="h-screen w-screen" v-if="!isLoading">
    <VueFlow :nodes="nodes" :edges="edges">
      <template #node-person>
        <PersonNode />
      </template>
      <template #node-spouse>
        some thing
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
