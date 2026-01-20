<script setup lang="ts">
import { h, nextTick, onMounted, reactive, ref } from 'vue'
import { Background } from '@vue-flow/background'
import { MarkerType, useVueFlow, VueFlow } from '@vue-flow/core'
import EdgeWithButton from '@/components/EdgeWithButton.vue'
import CustomEdge from '@/components/CustomEdge.vue'
import PersonNode from '@/components/nodes/PersonNode.vue'
import { MiniMap } from '@vue-flow/minimap'
import PersonModal from '@/components/PersonModal.vue'
import { useLayout } from '@/composables/useLayout'
import SearchPanel from '@/components/SearchPanel.vue'
import { useCollapse } from '@/composables/useCollapse'
import type { Edge, Node } from '@vue-flow/core'
import { useFamilyTreeStore } from '@/store/familyTree'
import SpouseNode from '@/components/nodes/SpouseNode.vue'

const nodes = ref<Node[]>([])
const edges = ref<Edge[]>([])
const selectedNodeId = ref(null)
const familyStore = useFamilyTreeStore()

const { fitView } = useVueFlow()

onMounted(async () => {
  await familyStore.initStore()
  nodes.value = familyStore.nodes
  edges.value = familyStore.edges

  await nextTick()
  fitView()
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

  nodes.value.push({
    id,
    type: 'person',
    data: {
      name: relationForm.name || 'New Person',
      birth: relationForm.birth || '',
      avatar: relationForm.avatar || `https://i.pravatar.cc/80?u=${id}`,
    },
  } as any)

  edges.value.push({
    id: `e-${id}`,
    source: source?.id || '',
    target: id,
    // 'bottom-source',
    // 'top-target',
    type: 'smoothstep',
    data: { relation: relationForm.relationType },
  })

  const {nodes: nodeFormat, edges: edgeFormat} = familyStore.renderGraph(nodes.value, edges.value)

  nodes.value = nodeFormat
  edges.value = edgeFormat

  showRelationDialog.value = false

  // wait DOM update then fit viewport (do not override node positions with resetLayout)
  nextTick().then(() => fitView({ padding: 0.12 }))
}

function cancelAddRelation() {
  showRelationDialog.value = false
}

function clearSelection() {
  selectedNodeId.value = null
  familyStore.selectNode(null)

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
  familyStore.selectNode(nodeId)

  const highlightIds = getHighlightIds(nodeId)

  // mark nodes for highlight
  nodes.value = nodes.value.map((n) => {
    return { ...n, data: { ...(n.data || {}), _highlight: highlightIds.has(n.id) } }
  })

  // update edges: highlight edges connected to highlighted nodes
  edges.value = edges.value.map((e) => {
    const related = highlightIds.has(e.source) || highlightIds.has(e.target)
    const copy = { ...e }
    if (related) {
      copy.style = { ...(copy.style || {}), stroke: '#f59e0b', strokeWidth: 3, opacity: 1 }
    } else {
      copy.style = { ...(copy.style || {}), opacity: 0.12 }
    }
    return copy
  })
}

function getHighlightIds(nodeId: string) {
  const highlights = new Set([nodeId])
  // find spouse node
  const spouseEdge = edges.value.find(e => e.data?.relation === 'spouse' && (e.source === nodeId || e.target === nodeId))
  if (spouseEdge) {
    const spouseId = spouseEdge.source === nodeId ? spouseEdge.target : spouseEdge.source
    highlights.add(spouseId)
    // add other spouses
    edges.value.filter(e => e.data?.relation === 'spouse' && e.source === spouseId).forEach(e => highlights.add(e.target))
    edges.value.filter(e => e.data?.relation === 'spouse' && e.target === spouseId).forEach(e => highlights.add(e.source))
    // add children
    edges.value.filter(e => e.data?.relation === 'parent' && e.source === spouseId).forEach(e => highlights.add(e.target))
  } else {
    // if no spouse, direct
    edges.value.filter(e => e.source === nodeId && e.data?.relation === 'parent').forEach(e => highlights.add(e.target))
    edges.value.filter(e => e.target === nodeId && e.data?.relation === 'parent').forEach(e => highlights.add(e.source))
  }
  return highlights
}

const { resetLayout } = useLayout(nodes, edges)
const { toggleBranch, collapsedMap } = useCollapse(nodes, edges)

// expose toggle handler used by PersonNode slot
function onToggleBranch(payload) {
  toggleBranch(payload.sourceId || payload) // payload may be { sourceId } or id
}
// --- INSERT SEARCH LOGIC BELOW ---
const searchName = ref('')
const searchAge = ref('')

function clearSearch() {
  searchName.value = ''
  searchAge.value = ''
  // restore default visuals
  clearSelection()
}

function performSearch() {
  const q = (searchName.value || '').trim().toLowerCase()
  const ageQ = searchAge.value ? parseInt(searchAge.value, 10) : NaN

  // find matched nodes
  const matched = familyStore.nodes.value.filter((n) => {
    const name = ((n.data && n.data.name) || n.label || '').toString().toLowerCase()
    const nameMatch = q ? name.includes(q) : true

    let ageMatch = true
    if (!Number.isNaN(ageQ)) {
      const birth = n.data?.birth
      if (!birth) ageMatch = false
      else {
        const b = new Date(birth)
        if (Number.isNaN(b.getTime())) ageMatch = false
        else {
          const age = Math.floor((Date.now() - b.getTime()) / (1000 * 60 * 60 * 24 * 365.25))
          ageMatch = age === ageQ
        }
      }
    }

    return nameMatch && ageMatch
  })

  const matchedIds = new Set(matched.map((m) => m.id))

  // highlight matched nodes
  nodes.value = nodes.value.map((n) => ({
    ...n,
    data: { ...(n.data || {}), _highlight: matchedIds.has(n.id) },
  }))

  // highlight edges that connect to matched nodes, dim others
  edges.value = edges.value.map((e) => {
    const related = matchedIds.has(e.source) || matchedIds.has(e.target)
    const copy = { ...e }
    if (related)
      copy.style = { ...(copy.style || {}), stroke: '#06b6d4', strokeWidth: 3, opacity: 1 }
    else copy.style = { ...(copy.style || {}), opacity: 0.12 }
    return copy
  })

  // clear selectedNodeId because search can select multiple
  selectedNodeId.value = null
  familyStore.selectNode(null)
}
// --- END SEARCH LOGIC ---
</script>

<template>
  <div class="h-screen w-screen">
    <!-- <SearchPanel @search="performSearch" @clear="clearSearch" /> -->
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

      <template #node-spouse>
        <SpouseNode />
      </template>

      <template #node-person="personNodeProps">
        <PersonNode
          v-bind="personNodeProps"
          @add-relation="onAddRelationIntent"
          @toggle-branch="onToggleBranch"
        />
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
