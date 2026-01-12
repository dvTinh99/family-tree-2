<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { VueFlow, Node, Edge } from '@vue-flow/core'
import PersonNode from './nodes/PersonNode.vue'
import { layoutFamilyTree } from '@/utils/familyTreeLayout'
import type { Person } from '@/types/family'

const nodes = ref<Node<{ person: Person }>[]>(
  []
)

const edges = ref<Edge[]>([])

const nodeTypes = {
  person: PersonNode,
}

function mapData(
  people: Person[],
  relations: { parent_id: string; child_id: string }[]
) {
  const rawNodes: Node<{ person: Person }>[] = people.map(p => ({
    id: p.id,
    type: 'person',
    data: { person: p },
    position: { x: 0, y: 0 },
  }))

  const rawEdges: Edge[] = relations.map((r, i) => ({
    id: `e-${r.parent_id}-${r.child_id}-${i}`,
    source: r.parent_id,
    target: r.child_id,
  }))

  return {
    rawNodes,
    rawEdges,
  }
}

onMounted(async () => {
  // TODO: fetch từ backend API
  const people: Person[] = [
    { id: '1', name: 'Ông A', gender: 'male', birth: '1950' },
    { id: '2', name: 'Bố B', gender: 'male', birth: '1975' },
    { id: '3', name: 'Mẹ C', gender: 'female', birth: '1978' },
    { id: '4', name: 'Con D', gender: 'male', birth: '2000' },
  ]

  const relations = [
    { parent_id: '1', child_id: '2' },
    { parent_id: '1', child_id: '3' },
    { parent_id: '2', child_id: '4' },
    { parent_id: '3', child_id: '4' },
  ]

  const { rawNodes, rawEdges } = mapData(people, relations)

  nodes.value = layoutFamilyTree(rawNodes, rawEdges)
  edges.value = rawEdges
})
</script>

<template>
  <div class="h-screen w-full">
    <VueFlow
      :nodes="nodes"
      :edges="edges"
      :node-types="nodeTypes"
      :min-zoom="0.5"
      :max-zoom="1.2"
    />

  </div>
</template>
