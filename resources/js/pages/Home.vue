<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { VueFlow, Node, Edge } from '@vue-flow/core'
import PersonNode from '@/components/nodes/PersonNode.vue'
import NodeMenu from '@/components/NodeMenu.vue'

const menuX = ref(0)
const menuY = ref(0)
const menuVisible = ref(false)
const selectedPerson = ref('')

const modalVisible = ref(false)
const currentRelation = ref('')

import { applyLayout } from '../utils/familyTreeLayout'

interface Person {
  id: string
  name: string
  gender: string
  birth?: string
  death?: string
}

const nodes = ref<Node[]>([])
const edges = ref<Edge[]>([])

const nodeTypes = { person: PersonNode }

function makeMarriageNode(a: string, b: string): Node {
  return {
    id: `m-${a}-${b}`,
    type: 'default',
    data: {},
    position: { x: 0, y: 0 },
  }
}

onMounted(async () => {
  const people: Person[] = [
    { id: '1', name: 'Ông A', gender: 'male', birth: '1950' },
    { id: '2', name: 'Bố B', gender: 'male', birth: '1975' },
    { id: '3', name: 'Mẹ C', gender: 'female', birth: '1978' },
    { id: '4', name: 'Con D', gender: 'male', birth: '2000' },
  ]

  const relations = [{ parent1: '2', parent2: '3', child: '4' }]

  const rawNodes: Node[] = people.map((p) => ({
    id: p.id,
    type: 'person',
    data: p,
    position: { x: 0, y: 0 },
  }))

  const rawEdges: Edge[] = []

  relations.forEach((r) => {
    const m = makeMarriageNode(r.parent1, r.parent2)
    rawNodes.push(m)

    rawEdges.push({
      id: `e-${r.parent1}-${m.id}`,
      source: r.parent1,
      target: m.id,
      type: 'smoothstep',
    })
    rawEdges.push({
      id: `e-${r.parent2}-${m.id}`,
      source: r.parent2,
      target: m.id,
      type: 'smoothstep',
    })
    rawEdges.push({ id: `e-${m.id}-${r.child}`, source: m.id, target: r.child, type: 'smoothstep' })
  })

  const { nodes: n, edges: e } = applyLayout(rawNodes, rawEdges)
  nodes.value = n
  edges.value = e
})

// Khi chọn node
function onSelectPerson(id: string, evt: MouseEvent) {
  selectedPerson.value = id
  menuVisible.value = true
  menuX.value = evt.clientX
  menuY.value = evt.clientY
}

function onChooseRelation(relation: string) {
  menuVisible.value = false

  // Mở modal form nhập tên + birth/death
  openRelationModal(relation, selectedPerson.value)
}

/**
 * Opens the modal for adding a related person.
 * @param relation One of: 'child', 'father', 'mother', 'spouse'
 * @param personId The ID of the selected person node
 */
function openRelationModal(relation: string, personId: string) {
  currentRelation.value = relation
  selectedPerson.value = personId
  modalVisible.value = true
}

function addRelation(relation: string, data: any) {
  const newId = `${Date.now()}`
  nodes.value.push({
    id: newId,
    type: 'person',
    data: {
      name: data.name,
      gender: relation === 'mother' ? 'female' : 'male',
      birth: data.birth,
      death: data.death,
    },
    position: { x: menuX.value, y: menuY.value },
  })

  // Tạo edge
  if (relation === 'child') {
    edges.value.push({
      id: `e-${selectedPerson.value}-${newId}`,
      source: selectedPerson.value,
      target: newId,
    })
  }
  if (relation === 'father' || relation === 'mother') {
    edges.value.push({
      id: `e-${newId}-${selectedPerson.value}`,
      source: newId,
      target: selectedPerson.value,
    })
  }
  if (relation === 'spouse') {
    edges.value.push({
      id: `e-${selectedPerson.value}-${newId}`,
      source: selectedPerson.value,
      target: newId,
      type: 'smoothstep',
    })
  }

  // Auto layout lại
  const { nodes: newNodes, edges: newEdges } = applyLayout(nodes.value, edges.value)
  nodes.value = newNodes
  edges.value = newEdges
}
</script>

<template>
  <div class="h-full w-full">
    <VueFlow
      :nodes="nodes"
      :edges="edges"
      :node-types="nodeTypes"
      fit-view
      :nodes-draggable="true"
      :pan-on-scroll="true"
      :zoom-on-scroll="true"
      :min-zoom="0.4"
      :max-zoom="1.4"
    />

    <PersonNode
      v-for="node in nodes"
      :key="node.id"
      :data="node.data"
      @select-person="(id, ev) => onSelectPerson(id, ev)"
    />

    <NodeMenu :x="menuX" :y="menuY" :visible="menuVisible" @select-relation="onChooseRelation" />

    <AddPersonModal
      v-if="modalVisible"
      :relation="currentRelation"
      :parentId="selectedPerson"
      @submit="addRelation(currentRelation, $event)"
      @close="modalVisible = false"
    />
  </div>
</template>
