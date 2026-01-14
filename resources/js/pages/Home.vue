<script setup>
import { h, nextTick, onMounted, ref } from 'vue'
import { Background } from '@vue-flow/background'
import { MarkerType, useVueFlow, VueFlow } from '@vue-flow/core'
import EdgeWithButton from '@/components/EdgeWithButton.vue'
import CustomEdge from '@/components/CustomEdge.vue'
import PersonNode from '@/components/nodes/PersonNode.vue'
import CustomEdgeLabel from '@/components/CustomEdgeLabel.vue'
import { MiniMap } from '@vue-flow/minimap'

import { nodesInit, edgesInit } from './initial-elements'

const nodes = ref([])
const edges = ref([])

function addNode() {
  const id = Date.now().toString()

  nodes.value.push({
    id,
    position: { x: 150, y: 50 },
    data: { label: `Node ${id}` },
  })
}

const { fitView } = useVueFlow()
onMounted(async () => {
  nodes.value = nodesInit
  edges.value = edgesInit
  // wait for VueFlow to mount and DOM to update
  await nextTick()
  fitView({ padding: 0.12 })
})
</script>

<template>
  <div class="h-screen w-screen">
    <VueFlow :nodes="nodes" :edges="edges" fit-view-on-init>
      <template #edge-button="buttonEdgeProps">
        <EdgeWithButton
          :id="buttonEdgeProps.id"
          :source-x="buttonEdgeProps.sourceX"
          :source-y="buttonEdgeProps.sourceY"
          :target-x="buttonEdgeProps.targetX"
          :target-y="buttonEdgeProps.targetY"
          :source-position="buttonEdgeProps.sourcePosition"
          :target-position="buttonEdgeProps.targetPosition"
          :marker-end="buttonEdgeProps.markerEnd"
          :style="buttonEdgeProps.style"
        />
      </template>

      <template #edge-custom="customEdgeProps">
        <CustomEdge
          :id="customEdgeProps.id"
          :source-x="customEdgeProps.sourceX"
          :source-y="customEdgeProps.sourceY"
          :target-x="customEdgeProps.targetX"
          :target-y="customEdgeProps.targetY"
          :source-position="customEdgeProps.sourcePosition"
          :target-position="customEdgeProps.targetPosition"
          :data="customEdgeProps.data"
          :marker-end="customEdgeProps.markerEnd"
          :style="customEdgeProps.style"
        />
      </template>

      <template #node-person="personNodeProps">
        <PersonNode v-bind="personNodeProps" />
      </template>

      <Panel>
        <button type="button" @click="addNode">Add a node</button>
      </Panel>

      <Background />
      <MiniMap />
    </VueFlow>
  </div>
</template>
<style scoped>
@import 'https://cdn.jsdelivr.net/npm/@vue-flow/core@1.48.1/dist/style.css';
@import 'https://cdn.jsdelivr.net/npm/@vue-flow/core@1.48.1/dist/theme-default.css';
@import 'https://cdn.jsdelivr.net/npm/@vue-flow/controls@latest/dist/style.css';
@import 'https://cdn.jsdelivr.net/npm/@vue-flow/minimap@latest/dist/style.css';
@import 'https://cdn.jsdelivr.net/npm/@vue-flow/node-resizer@latest/dist/style.css';

html,
body,
#app {
  margin: 0;
  height: 100%;
}

#app {
  text-transform: uppercase;
  font-family: 'JetBrains Mono', monospace;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
}

.vue-flow__minimap {
  transform: scale(75%);
  transform-origin: bottom right;
}

.edgebutton {
  border-radius: 999px;
  cursor: pointer;
}

.edgebutton:hover {
  transform: scale(1.1);
  transition: all ease 0.5s;
  box-shadow:
    0 0 0 2px #10b98180,
    0 0 0 4px #10b981;
}
</style>
