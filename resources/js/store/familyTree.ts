import { defineStore } from 'pinia'
import { ref, computed } from 'vue'
import type { Node, Edge } from '@vue-flow/core'
import { useApi } from '@/composables/useApi'
import { familyTreeLayout, applyRelationHandles } from '@/utils/familyTreeLayout'

export const useFamilyTreeStore = defineStore(
  'familyTree',
  () => {
    // state
    const nodes = ref<Node[]>([])
    const edges = ref<Edge[]>([])

    const selectedNodeId = ref<string | null>(null)

    // getters
    const nodeCount = computed(() => nodes.value.length)
    const edgesFormat = computed(() => applyRelationHandles(edges.value))
    const nodesFormat = computed(() => familyTreeLayout(nodes.value, edges.value))

    // actions

    async function initStore() {
      const { data, error, isLoading } = await useApi<{ nodes: Node[]; edges: Edge[] }>(
        '/api/family-tree'
      )
      console.log('datane', data.value)

      nodes.value = data.value?.nodes || []
      edges.value = data.value?.edges || []
    }

    function setNodes(newNodes: Node[]) {
      nodes.value = newNodes
    }

    function setEdges(newEdges: Edge[]) {
      edges.value = newEdges
    }

    function addNode(node: Node) {
      nodes.value.push(node)
    }

    function addEdge(edge: Edge) {
      edges.value.push(edge)
    }

    function updateNodePosition(id: string, x: number, y: number) {
      const node = nodes.value.find((n) => n.id === id)
      if (node) {
        node.position = { x, y }
      }
    }

    function selectNode(id: string | null) {
      selectedNodeId.value = id
    }

    return {
      // state
      nodes,
      edges,
      selectedNodeId,

      // getters
      nodeCount,
      edgesFormat,
      nodesFormat,

      // actions
      initStore,
      setNodes,
      setEdges,
      addNode,
      addEdge,
      updateNodePosition,
      selectNode,
    }
  },
  {
    persist: {
      storage: sessionStorage,
      pick: ['nodes', 'edges'],
    },
  }
)
