import { defineStore } from 'pinia'
import { ref, computed } from 'vue'
import type { Node, Edge } from '@vue-flow/core'
import { useApi } from '@/composables/useApi'
import { familyTreeLayout, addSpouseAndRerouteParents } from '@/utils/familyTreeLayout'

export const useFamilyTreeStore = defineStore(
  'familyTree',
  () => {
    // state
    const nodes = ref<Node[]>([])
    const edges = ref<Edge[]>([])

    const selectedNodeId = ref<string | null>(null)

    // getters
    const nodeCount = computed(() => nodes.value.length)

    // actions

    async function initStore() {
      const { data, error, isLoading } = await useApi<{ nodes: Node[]; edges: Edge[] }>(
        '/api/family-tree'
      )
      console.log('datane', data.value)

      const {nodes: nodeResult, edges: edgeResult} = renderGraph(data.value?.nodes || [], data.value?.edges || [])
      nodes.value = nodeResult
      edges.value = edgeResult
    }

    function renderGraph(nodesParam?: Node[], edgesParam?: Edge[]) {
      const {nodes: nodeResult, edges: edgeResult} = addSpouseAndRerouteParents(nodesParam || nodes.value, edgesParam || edges.value)
      const nodeFormat = familyTreeLayout(nodeResult, edgeResult)

      return { nodes: nodeFormat, edges: edgeResult}
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
      // actions
      initStore,
      setNodes,
      setEdges,
      addNode,
      addEdge,
      updateNodePosition,
      selectNode,
      renderGraph,
    }
  },
  {
    persist: {
      storage: sessionStorage,
      pick: ['nodes', 'edges'],
    },
  }
)
