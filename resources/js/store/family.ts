import { defineStore } from 'pinia'
import { ref, computed, watch, watchEffect } from 'vue'
import { type Node, type Edge, useVueFlow } from '@vue-flow/core'
import { useApi } from '@/composables/useApi'
import {
  familyTreeLayout,
  addSpouseAndRerouteParents,
  applyRelationHandles,
} from '@/utils/familyTreeLayout'
const { fitView, nodesDraggable, setViewport, setNodesSelection  } = useVueFlow()
export const useFamilyStore = defineStore(
  'family',
  () => {
    // state
    const nodesOrigin = ref<Node[]>([])
    const edgesOrigin = ref<Edge[]>([])
    const nodeSelected = ref<Node | null>(null)

    const selectedNodeId = ref<string | null>(null)

    // getters
    const nodeCount = computed(() => nodes.value.length)
    const formatGraph = computed(() => {
      const graphNodes = renderGraph()
      const highlightIds = getHighlightIds(nodeSelected?.value?.id)

      const { nodes: highlightedNodes, edges: highlightedEdges } = highlightNodes(
        highlightIds,
        graphNodes.nodes,
        graphNodes.edges
      )
      return { nodes: highlightedNodes, edges: highlightedEdges }
    })

    const nodes = ref<Node[]>(formatGraph.value.nodes)
    const edges = ref<Edge[]>(formatGraph.value.edges)
    const selectedNode = nodeSelected.value

    function recountNodeAndEdges() {
      nodes.value = formatGraph.value.nodes
      edges.value = formatGraph.value.edges
    }

    // actions
    async function initStore() {
      const { data, error, isLoading } = await useApi<{ nodes: Node[]; edges: Edge[] }>(
        '/api/family-tree'
      )

      nodesOrigin.value = data.value?.nodes as Node[]
      edgesOrigin.value = data.value?.edges as Edge[]
      recountNodeAndEdges()
    }

    function renderGraph(nodesParam?: Node[], edgesParam?: Edge[]) {
      const { nodes: nodeResult, edges: edgeResult } = addSpouseAndRerouteParents(
        nodesParam || nodesOrigin.value,
        edgesParam || edgesOrigin.value
      )
      const nodeFormat = familyTreeLayout(nodeResult, edgeResult)

      return { nodes: nodeFormat, edges: edgeResult }
    }

    function updateNodePosition(id: string, x: number, y: number) {
      const node = nodes.value.find((n) => n.id === id)
      if (node) {
        node.position = { x, y }
      }
    }

    function setNodeSelected(node: Node | null) {
      nodeSelected.value = node
    }

    function highlightNodes(highlightIds: Set<string> | null, nodes: Node[], edges: Edge[]) {
      if (!highlightIds) {
        // reset all
        const resetNodes = nodes.map((n) => ({
          ...n,
          data: { ...(n.data || {}), _highlight: false },
        }))
        const resetEdges = edges.map((e) => {
          const copy = { ...e }
          copy.style = undefined
          return copy
        })
        return { nodes: resetNodes, edges: resetEdges }
      }
      // mark nodes for highlight
      const newNodes = nodes.map((n) => {
        return { ...n, data: { ...(n.data || {}), _highlight: highlightIds.has(n.id) } }
      })

      // update edges: highlight edges connected to highlighted nodes
      const newEdges = edges.map((e) => {
        const related = highlightIds.has(e.source) || highlightIds.has(e.target)
        const copy = { ...e }
        if (related) {
          copy.style = { ...(copy.style || {}), stroke: '#f59e0b', strokeWidth: 3, opacity: 1 }
        } else {
          copy.style = { ...(copy.style || {}), opacity: 0.12 }
        }
        return copy
      })

      return { nodes: newNodes, edges: newEdges }
    }

    function getHighlightIds(nodeId: string | null): Set<string> | null {
      if (!nodeId) return null
      const highlights = new Set([nodeId])

      const findEdges = (relation: string, nodeKey: 'source' | 'target', nodeId: string): Edge[] =>
        edges.value.filter((e) => e.data?.relation === relation && e[nodeKey] === nodeId)

      // find spouse node
      const spouseEdge =
        findEdges('spouse', 'source', nodeId)[0] || findEdges('spouse', 'target', nodeId)[0]

      if (spouseEdge) {
        const spouseId = spouseEdge.source === nodeId ? spouseEdge.target : spouseEdge.source
        highlights.add(spouseId)
        ;['source', 'target'].forEach((key) => {
          findEdges('spouse', key as 'source' | 'target', spouseId).forEach((e) =>
            highlights.add(e[key === 'source' ? 'target' : 'source'])
          )
          findEdges('parent', key as 'source' | 'target', spouseId).forEach((e) =>
            highlights.add(e[key === 'source' ? 'target' : 'source'])
          )
        })
      } else {
        ;['source', 'target'].forEach((key) => {
          findEdges('parent', key as 'source' | 'target', nodeId).forEach((e) =>
            highlights.add(e[key === 'source' ? 'target' : 'source'])
          )
        })
      }

      return highlights
    }

    function $reset() {
      nodesOrigin.value = []
      edgesOrigin.value = []
      nodeSelected.value = null
    }

    return {
      // state
      nodes,
      edges,
      nodesOrigin,
      edgesOrigin,
      nodeSelected,

      // getters
      nodeCount,
      formatGraph,
      selectedNode,
      // actions
      initStore,
      updateNodePosition,
      setNodeSelected,
      renderGraph,
      recountNodeAndEdges,
      $reset,
    }
  },
  {
    persist: {
      storage: sessionStorage,
      pick: ['nodesOrigin', 'edgesOrigin'],
    },
  }
)
