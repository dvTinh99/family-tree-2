<script setup>
import { h, nextTick, onMounted, reactive, ref } from 'vue'
import { Background } from '@vue-flow/background'
import { MarkerType, useVueFlow, VueFlow } from '@vue-flow/core'
import EdgeWithButton from '@/components/EdgeWithButton.vue'
import CustomEdge from '@/components/CustomEdge.vue'
import PersonNode from '@/components/nodes/PersonNode.vue'
import CustomEdgeLabel from '@/components/CustomEdgeLabel.vue'
import { MiniMap } from '@vue-flow/minimap'
import PersonModal from '@/components/PersonModal.vue'

import { nodesInit, edgesInit } from './initial-elements'

const nodes = ref([])
const edges = ref([])
const selectedNodeId = ref(null)

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
  resetLayout()
})

const showRelationDialog = ref(false)
const relationForm = reactive({
  sourceId: '',
  relationType: '',
  name: '',
  birth: '',
  avatar: '',
})

function onAddRelationIntent({ sourceId, relationType }) {
  relationForm.sourceId = sourceId
  relationForm.relationType = relationType
  relationForm.name = '' // optional default
  relationForm.birth = ''
  relationForm.avatar = `https://i.pravatar.cc/80?u=${Date.now()}`
  showRelationDialog.value = true
}

function confirmAddRelation() {
  const id = Date.now().toString()
  const source = nodes.value.find((n) => n.id === relationForm.sourceId)
  const pos = source?.position || { x: 0, y: 0 }

  // base offsets per relation
  const offsets = {
    father: { x: -80, y: -160 },
    mother: { x: 80, y: -160 },
    child: { x: 0, y: 160 },
    sibling: { x: 140, y: 0 },
    spouse: { x: 110, y: 0 },
  }

  // choose offset (fallback if no type)
  let off = offsets[relationForm.relationType] || { x: 0, y: 140 }

  // small adjustments to avoid overlaps:
  // - if adding another child, shift horizontally based on existing child count
  if (relationForm.relationType === 'child' && source) {
    const childCount = edges.value.filter(
      (e) => e.source === source.id && e.data?.relation === 'child'
    ).length
    // center children under parent, spacing 120px
    const idx = childCount // new child's index (0-based)
    const center = idx % 2 === 0 ? -(Math.floor(idx / 2) * 120) : Math.ceil(idx / 2) * 120
    off.x = center
    off.y = 160
  }

  // - if adding sibling, place to the right but stagger vertically slightly
  if (relationForm.relationType === 'sibling' && source) {
    const siblingCount = nodes.value.filter((n) => {
      // rough heuristic: siblings are nodes that share at least one parent via edges
      return edges.value.some(
        (e) =>
          e.source !== source.id &&
          e.target === n.id &&
          edges.value.some((pe) => pe.source === e.source && pe.target === source.id)
      )
    }).length
    off.x = 140
    off.y = siblingCount * 12 // stagger a bit
  }

  // shift position relative to source
  const newPos = { x: pos.x + off.x, y: pos.y + off.y }

  nodes.value.push({
    id,
    type: 'person',
    position: newPos,
    data: {
      name: relationForm.name || 'New Person',
      birth: relationForm.birth || '',
      avatar: relationForm.avatar || `https://i.pravatar.cc/80?u=${id}`,
    },
  })

  // determine handle mapping per relation
  let sourceIdForEdge = relationForm.sourceId
  let targetIdForEdge = id
  let sourceHandle = undefined
  let targetHandle = undefined

  if (relationForm.relationType === 'father' || relationForm.relationType === 'mother') {
    // new parent above current: edge from new(bottom) -> current(top)
    sourceIdForEdge = id
    targetIdForEdge = relationForm.sourceId
    sourceHandle = 'bottom-source'
    targetHandle = 'top-target'
  } else if (relationForm.relationType === 'child') {
    // child below current: current(bottom) -> new(top)
    sourceIdForEdge = relationForm.sourceId
    targetIdForEdge = id
    sourceHandle = 'bottom-source'
    targetHandle = 'top-target'
  } else if (relationForm.relationType === 'spouse') {
    // spouse: from left side of current to right side of new
    sourceIdForEdge = relationForm.sourceId
    targetIdForEdge = id
    sourceHandle = 'left-source'
    targetHandle = 'right-target'
  } else if (relationForm.relationType === 'sibling') {
    // sibling: place to the right, connect current(right) -> new(left)
    sourceIdForEdge = relationForm.sourceId
    targetIdForEdge = id
    sourceHandle = 'right-source'
    targetHandle = 'left-target'
  } else {
    // fallback: default connection current -> new
    sourceIdForEdge = relationForm.sourceId
    targetIdForEdge = id
    sourceHandle = 'bottom-source'
    targetHandle = 'top-target'
  }

  edges.value.push({
    id: `e-${sourceIdForEdge}-${targetIdForEdge}`,
    source: sourceIdForEdge,
    target: targetIdForEdge,
    sourceHandle,
    targetHandle,
    type: 'smoothstep',
    data: { relation: relationForm.relationType },
  })

  showRelationDialog.value = false

  // wait DOM update then fit viewport (do not override node positions with resetLayout)
  nextTick().then(() => fitView({ padding: 0.12 }))
}

function cancelAddRelation() {
  showRelationDialog.value = false
}

function clearSelection() {
  selectedNodeId.value = null

  // reset edge styles and node highlight marker
  edges.value = edges.value.map((e) => {
    const copy = { ...e }
    copy.style = undefined
    return copy
  })
  nodes.value = nodes.value.map((n) => ({ ...n, data: { ...(n.data || {}), _highlight: false } }))
}

function onNodeClick({ node }) {
  const nodeId = node.id
  selectedNodeId.value = nodeId

  // parents: edges where target === nodeId
  const parentIds = edges.value.filter((e) => e.target === nodeId).map((e) => e.source)
  // children: edges where source === nodeId
  const childIds = edges.value.filter((e) => e.source === nodeId).map((e) => e.target)

  // update edges: highlight edges connected to the node or between its parents/children; dim others
  edges.value = edges.value.map((e) => {
    const related =
      e.source === nodeId ||
      e.target === nodeId ||
      parentIds.includes(e.source) ||
      childIds.includes(e.target)
    const copy = { ...e }
    if (related) {
      copy.style = { ...(copy.style || {}), stroke: '#f59e0b', strokeWidth: 3, opacity: 1 }
    } else {
      copy.style = { ...(copy.style || {}), opacity: 0.12 }
    }
    return copy
  })

  // mark selected node and parent nodes for node-level highlight (PersonNode reads data._highlight)
  nodes.value = nodes.value.map((n) => {
    const isParent = parentIds.includes(n.id)
    const isSelected = n.id === nodeId
    return { ...n, data: { ...(n.data || {}), _highlight: isParent || isSelected } }
  })
}

// hierarchical layout: BFS levels from roots (no incoming edges)
function applyHierarchyLayout(nodesArr, edgesArr, hSpacing = 220, vSpacing = 140) {
  const idToNode = new Map(nodesArr.map((n) => [n.id, { ...n }]))

  // incoming/outgoing maps
  const incoming = new Map()
  const outgoing = new Map()
  edgesArr.forEach((e) => {
    incoming.set(e.target, (incoming.get(e.target) || 0) + 1)
    outgoing.set(e.source, (outgoing.get(e.source) || []).concat(e.target))
  })

  // find root nodes (no incoming)
  let roots = nodesArr.filter((n) => !incoming.has(n.id)).map((n) => n.id)
  if (roots.length === 0 && nodesArr.length > 0) roots = [nodesArr[0].id]

  // BFS to assign level per node
  const levels = new Map()
  const q = []
  roots.forEach((r) => {
    levels.set(r, 0)
    q.push(r)
  })
  while (q.length) {
    const id = q.shift()
    const lvl = levels.get(id)
    const children = outgoing.get(id) || []
    children.forEach((c) => {
      if (!levels.has(c)) {
        levels.set(c, lvl + 1)
        q.push(c)
      }
    })
  }

  // ensure all nodes have a level
  nodesArr.forEach((n) => {
    if (!levels.has(n.id)) levels.set(n.id, 0)
  })

  // group by level then assign positions
  const levelMap = new Map()
  nodesArr.forEach((n) => {
    const lvl = levels.get(n.id)
    if (!levelMap.has(lvl)) levelMap.set(lvl, [])
    levelMap.get(lvl).push(n.id)
  })

  for (const [lvl, ids] of levelMap.entries()) {
    const count = ids.length
    ids.forEach((nodeId, idx) => {
      const x = (idx - (count - 1) / 2) * hSpacing
      const y = lvl * vSpacing
      const node = idToNode.get(nodeId)
      if (node) node.position = { x, y }
    })
  }

  return Array.from(idToNode.values())
}

function resetLayout() {
  nodes.value = applyHierarchyLayout(nodes.value, edges.value)
  nextTick().then(() => fitView({ padding: 0.12 }))
}
</script>

<template>
  <div class="h-screen w-screen">
    <button @click="resetLayout" class="layout-reset-btn" title="Reset layout">
      ⤒ Reset layout
    </button>
    <div v-if="showRelationDialog" class="border-l">
      <PersonModal
        v-model="relationForm"
        @confirm="confirmAddRelation"
        @cancel="cancelAddRelation"
      />
    </div>
    <VueFlow
      :nodes="nodes"
      :edges="edges"
      fit-view-on-init
      @node-click="onNodeClick"
      @pane-click="clearSelection"
    >
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
        <PersonNode v-bind="personNodeProps" @add-relation="onAddRelationIntent" />
      </template>

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

.layout-reset-btn {
  position: fixed;
  right: 18px;
  bottom: 18px;
  z-index: 60;
  background: #111827;
  color: #fff;
  border: none;
  padding: 10px 12px;
  border-radius: 8px;
  box-shadow: 0 6px 18px rgba(2, 6, 23, 0.2);
  cursor: pointer;
}
.layout-reset-btn:hover {
  transform: translateY(-2px);
  transition: all 0.12s ease;
}
</style>
<style>
.vue-flow__node-toolbar {
  display: flex;
  gap: 0.5rem;
  align-items: center;
  background-color: #2d3748;
  padding: 8px;
  border-radius: 8px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
}

.vue-flow__node-toolbar button {
  background: #4a5568;
  color: white;
  border: none;
  padding: 0.5rem 1rem;
  border-radius: 8px;
  cursor: pointer;
}

.vue-flow__node-toolbar button.selected {
  background: #2563eb;
}

.vue-flow__node-toolbar button:hover {
  background: #2563eb;
}

.vue-flow__node-menu {
  padding: 16px 24px;
  border-radius: 8px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
}

.vue-flow__node-menu.selected {
  box-shadow: 0 0 0 2px #2563eb;
}
</style>
