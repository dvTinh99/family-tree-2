<script setup lang="ts">
import { ref, onMounted, nextTick } from 'vue'
import { Background } from '@vue-flow/background'
import { useVueFlow, VueFlow } from '@vue-flow/core'
import type { Edge, Node } from '@vue-flow/core'
import { Controls } from '@vue-flow/controls'
import { Panel } from '@vue-flow/core'
import { MarkerType } from '@vue-flow/core'
import { BackgroundVariant } from '@vue-flow/background'
import PersonNode from '@/components/nodes/PersonNode.vue'
import ToolbarNode from '@/components/nodes/ToolbarNode.vue'
import PersonModalSimple from '@/components/PersonModalSimple.vue'
import dagre from '@dagrejs/dagre'
import * as domToImage from 'dom-to-image-more'
import '@vue-flow/core/dist/style.css'
import '@vue-flow/controls/dist/style.css'

const { nodes, edges, fitView, setViewport, addNodes, addEdges } = useVueFlow()

const isLoading = ref(false)
const showModal = ref(false)
const selectedNodeId = ref<string | null>(null)
const selectedRelationType = ref<string>('child')

const nodeLocal = ref<Node[]>()
const edgeLocal = ref<Edge[]>()

interface Person {
  id: string
  name: string
  gender: 1 | 2
  birthday?: string
  avatar?: string
}

interface FamilyEdge {
  id: string
  source: string
  target: string
  relation: 'father' | 'mother' | 'child' | 'spouse'
}

const familyData = {
  people: [
    { id: '1', name: 'Grandfather', gender: 1, birthday: '1950-01-01' },
    { id: '2', name: 'Grandmother', gender: 2, birthday: '1952-05-15' },
    { id: '3', name: 'Father', gender: 1, birthday: '1975-03-20' },
    { id: '4', name: 'Mother', gender: 2, birthday: '1978-08-10' },
    { id: '5', name: 'Son', gender: 1, birthday: '2000-06-01' },
    { id: '6', name: 'Daughter', gender: 2, birthday: '2002-11-20' },
  ],
  relationships: [
    { id: 'e1', source: '1', target: '3', relation: 'father' },
    { id: 'e2', source: '2', target: '3', relation: 'mother' },
    { id: 'e3', source: '3', target: '4', relation: 'spouse' },
    { id: 'e4', source: '3', target: '5', relation: 'child' },
    { id: 'e5', source: '3', target: '6', relation: 'child' },
    { id: 'e6', source: '4', target: '5', relation: 'child' },
    { id: 'e7', source: '4', target: '6', relation: 'child' },
  ],
}

function createNodes(personList: typeof familyData.people): Node[] {
  return personList.map((person) => ({
    id: person.id,
    type: 'person',
    position: { x: 0, y: 0 },
    data: {
      label: person.name,
      name: person.name,
      avatar: person.avatar,
      birthday: person.birthday,
      gender: person.gender,
    },
  }))
}

function createEdges(relList: typeof familyData.relationships): Edge[] {
  return relList.map((rel) => ({
    id: rel.id,
    source: String(rel.source),
    target: String(rel.target),
    type: rel.relation === 'spouse' ? 'smoothstep' : 'step',
    data: { relation: rel.relation },
    markerEnd: MarkerType.ArrowClosed,
    style: { stroke: '#64748b', strokeWidth: 2 },
  }))
}

function processSpouseAndLayout(nodeList: Node[], edgeList: Edge[]) {
  const newNodes: Node[] = [...nodeList]
  const newEdges: Edge[] = []
  const spousePairs = new Set<string>()
  const parentToSpouse: Record<string, string> = {}

  edgeList.forEach((edge) => {
    if (edge.data?.relation === 'spouse') {
      const key = [String(edge.source), String(edge.target)].sort().join('-')
      if (!spousePairs.has(key)) {
        spousePairs.add(key)
        const spouseId = `spouse-${String(edge.source)}-${String(edge.target)}`
        const idx = newNodes.findIndex((n) => n.id === String(edge.source))
        newNodes.splice(idx + 1, 0, {
          id: spouseId,
          type: 'spouse',
          position: { x: 0, y: 0 },
          data: { width: 50, height: 50 },
        })
        parentToSpouse[String(edge.source)] = spouseId
        parentToSpouse[String(edge.target)] = spouseId
        newEdges.push({
          id: `spouse-edge-${String(edge.source)}`,
          source: String(edge.source),
          target: spouseId,
          type: 'smoothstep',
          data: { relation: 'parent' },
          sourceHandle: 'bottom-source',
          targetHandle: 'left-target',
          style: { stroke: '#64748b', strokeWidth: 2 },
        })
        newEdges.push({
          id: `spouse-edge-${String(edge.target)}`,
          source: String(edge.target),
          target: spouseId,
          type: 'smoothstep',
          data: { relation: 'parent' },
          sourceHandle: 'bottom-source',
          targetHandle: 'right-target',
          style: { stroke: '#64748b', strokeWidth: 2 },
        })
      }
    }
  })

  edgeList.forEach((edge) => {
    if (edge.data?.relation === 'spouse') return
    if (['father', 'mother', 'child', 'parent'].includes(edge.data?.relation || '')) {
      const spouseNode = parentToSpouse[String(edge.source)]
      if (spouseNode) {
        newEdges.push({ ...edge, source: spouseNode })
      } else {
        newEdges.push(edge)
      }
    } else {
      newEdges.push(edge)
    }
  })

  const g = new dagre.graphlib.Graph()
  g.setDefaultEdgeLabel(() => ({}))
  g.setGraph({ rankdir: 'TB', ranksep: 120, nodesep: 80 })

  const DEFAULT_W = 180
  const DEFAULT_H = 90

  newNodes.forEach((node) => {
    g.setNode(node.id, {
      width: node.data?.width || DEFAULT_W,
      height: node.data?.height || DEFAULT_H,
    })
  })

  newEdges.forEach((edge) => {
    const rel = edge.data?.relation
    if (rel === 'father' || rel === 'mother' || rel === 'child' || rel === 'parent') {
      g.setEdge(String(edge.source), String(edge.target))
    }
  })

  dagre.layout(g)

  const layoutedNodes = newNodes.map((node) => {
    const dagreNode = g.node(node.id)
    if (!dagreNode) {
      return { ...node, position: { x: 100, y: 100 } }
    }
    const dNode = dagreNode as { x: number; y: number }
    return {
      ...node,
      position: { x: dNode.x || 100, y: dNode.y || 100 },
    }
  })

  const finalEdges = newEdges.map((edge) => {
    const rel = edge.data?.relation
    const baseStyle = { stroke: '#64748b', strokeWidth: 2 }
    if (rel === 'spouse') {
      return {
        ...edge,
        sourceHandle: 'right-source',
        targetHandle: 'left-target',
        type: 'smoothstep',
        style: baseStyle,
      }
    }
    if (['father', 'mother', 'child', 'parent'].includes(rel || '')) {
      return {
        ...edge,
        sourceHandle: 'bottom-source',
        targetHandle: 'top-target',
        type: 'step',
        style: baseStyle,
      }
    }
    return { ...edge, type: 'step', style: baseStyle }
  })

  return { nodes: layoutedNodes, edges: finalEdges }
}

function loadTree() {
  isLoading.value = true
  const vueNodes = createNodes(familyData.people)
  const vueEdges = createEdges(familyData.relationships)
  const result = processSpouseAndLayout(vueNodes, vueEdges)
  nodeLocal.value = result.nodes
  edgeLocal.value = result.edges
  isLoading.value = false
}

function resetView() {
  setViewport({ x: 0, y: 0, zoom: 1 })
  nextTick(() => {
    setTimeout(() => fitView({ padding: 0.2 }), 50)
  })
}

function onNodeClick({ node }: { node: Node }) {
  selectedNodeId.value = node.id
}

function onAddRelation(payload: { sourceId: string; relationType: string }) {
  selectedNodeId.value = payload.sourceId
  selectedRelationType.value = payload.relationType
  showModal.value = true
}

function onModalAdded(data: {
  name: string
  birth: Date
  gender: number
  avatar: string
  biography: string
  relationType: string
}) {
  if (!selectedNodeId.value) return

  const newId = String(Date.now())

  const newNode: Node = {
    id: newId,
    type: 'person',
    position: { x: 0, y: 0 },
    data: {
      label: data.name,
      name: data.name,
      avatar: data.avatar,
      birthday: data.birth?.toISOString?.() || '',
      gender: data.gender,
      biography: data.biography,
    },
  }

  const newEdge: Edge = {
    id: `edge-${selectedNodeId.value}-${newId}`,
    source: selectedNodeId.value,
    target: newId,
    type: 'step',
    data: { relation: data.relationType },
    sourceHandle: 'bottom-source',
    targetHandle: 'top-target',
    markerEnd: MarkerType.ArrowClosed,
    style: { stroke: '#64748b', strokeWidth: 2 },
  }

  addNodes(newNode)
  addEdges(newEdge)

  setTimeout(() => {
    const result = processSpouseAndLayout(nodes.value, edges.value)
    nodeLocal.value = result.nodes
    edgeLocal.value = result.edges
    setTimeout(() => fitView({ padding: 0.2 }), 100)
  }, 100)
}

function onModalCancel() {
  selectedNodeId.value = null
}

const isExporting = ref(false)

async function exportToPng() {
  const element = document.querySelector('.vue-flow') as HTMLElement
  if (!element) return

  isExporting.value = true
  element.classList.add('exporting')
  try {
    await nextTick()
    const dataUrl = await domToImage.toPng(element, {
      backgroundColor: '#f8fafc',
      pixelRatio: 2,
      style: {
        transform: 'translate(0, 0)',
        overflow: 'visible',
      },
    })
    const link = document.createElement('a')
    link.download = `family-tree-${Date.now()}.png`
    link.href = dataUrl
    link.click()
  } catch (error) {
    console.error('Failed to export PNG:', error)
  } finally {
    element.classList.remove('exporting')
    isExporting.value = false
  }
}

async function exportToSvg() {
  const element = document.querySelector('.vue-flow') as HTMLElement
  if (!element) return

  isExporting.value = true
  element.classList.add('exporting')
  try {
    await nextTick()
    const dataUrl = await domToImage.toSvg(element, {
      backgroundColor: '#f8fafc',
      style: {
        transform: 'translate(0, 0)',
        overflow: 'visible',
      },
    })
    const link = document.createElement('a')
    link.download = `family-tree-${Date.now()}.svg`
    link.href = dataUrl
    link.click()
  } catch (error) {
    console.error('Failed to export SVG:', error)
  } finally {
    element.classList.remove('exporting')
    isExporting.value = false
  }
}

onMounted(() => {
  nextTick(() => {
    loadTree()
    setTimeout(() => fitView({ padding: 0.2 }), 100)
  })
})
</script>

<template>
  <div class="h-screen w-screen relative">
    <VueFlow
      :nodes="nodeLocal"
      :edges="edgeLocal"
      :default-edge-options="{ type: 'step', animated: true, markerEnd: MarkerType.ArrowClosed }"
      :default-node-options="{ type: 'person' }"
      class="basic-flow"
      :default-viewport="{ zoom: 0.5 }"
      :min-zoom="0.1"
      :max-zoom="4"
      @node-click="onNodeClick"
    >
      <template #node-person="props">
        <PersonNode :id="props.id" :data="props.data" :node="props" @add-relation="onAddRelation" />
      </template>
      <template #node-menu="props">
        <ToolbarNode
          :id="props.id"
          :data="props.data"
          :node="props"
          @add-relation="onAddRelation"
        />
      </template>
      <Background :variant="BackgroundVariant.Dots" :gap="12" />
      <Controls position="top-left" />
      <Panel position="top-right" class="flex gap-2">
        <button
          class="px-3 py-1.5 bg-blue-600 text-white rounded shadow hover:bg-blue-700 text-sm"
          @click="resetView"
        >
          Reset View
        </button>
        <button
          class="px-3 py-1.5 bg-green-600 text-white rounded shadow hover:bg-green-700 text-sm"
          :disabled="isExporting"
          @click="exportToPng"
        >
          {{ isExporting ? 'Exporting...' : 'Export PNG' }}
        </button>
        <button
          class="px-3 py-1.5 bg-purple-600 text-white rounded shadow hover:bg-purple-700 text-sm"
          :disabled="isExporting"
          @click="exportToSvg"
        >
          Export SVG
        </button>
      </Panel>
    </VueFlow>

    <PersonModalSimple
      v-model:open="showModal"
      :relation-type="selectedRelationType"
      @added="onModalAdded"
      @cancel="onModalCancel"
    />

    <div
      v-if="isLoading"
      class="absolute inset-0 flex items-center justify-center bg-white/80 z-50"
    >
      <span>Loading...</span>
    </div>
  </div>
</template>

<style scoped>
.basic-flow {
  background-color: #f8fafc;
}
.basic-flow :deep(.vue-flow__node) {
  cursor: pointer;
}
</style>

<style>
.vue-flow.exporting {
  border: none !important;
  outline: none !important;
  box-shadow: none !important;
}

.vue-flow.exporting .vue-flow__viewport {
  border: none !important;
  outline: none !important;
  box-shadow: none !important;
}

.vue-flow.exporting .vue-flow__edge {
  outline: none !important;
}

.vue-flow.exporting .vue-flow__controls {
  display: none !important;
}

.vue-flow.exporting .vue-flow__minimap {
  display: none !important;
}
</style>
