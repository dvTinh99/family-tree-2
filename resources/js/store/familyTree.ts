import { defineStore } from 'pinia'
import { ref, computed } from 'vue'
import type { Node, Edge } from '@vue-flow/core'
import { useApi } from '@/composables/useApi'
import {
  familyTreeLayout,
  addSpouseAndRerouteParents,
  applyRelationHandles,
} from '@/utils/familyTreeLayout'

export const useFamilyTreeStore = defineStore(
  'familyTree',
  () => {
    // state
    const nodesOrigin = ref<Node[]>([
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
        data: {},
      },
      {
        id: '4',
        type: 'person',
        data: {},
      },
    ])
    const edgesOrigin = ref<Edge[]>([
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
      {
        id: 'e3',
        source: '1',
        target: '4',
        type: 'step',
        data: { relation: 'parent' },
        sourceHandle: 'bottom-source',
        targetHandle: 'top-target',
      },
    ])
    const nodeSelected = ref<Node | null>(null)

    const selectedNodeId = ref<string | null>(null)

    // getters
    const nodeCount = computed(() => nodes.value.length)
    const formatGraph = computed(() => renderGraph())
    const nodes = computed(() => formatGraph.value.nodes)
    const edges = computed(() => applyRelationHandles(formatGraph.value.edges))

    // actions

    async function initStore() {
      const { data, error, isLoading } = await useApi<{ nodes: Node[]; edges: Edge[] }>(
        '/api/family-tree'
      )
      console.log('datane', data.value)

      const { nodes: nodeResult, edges: edgeResult } = renderGraph(
        data.value?.nodes || [],
        data.value?.edges || []
      )
      nodes.value = nodeResult
      edges.value = edgeResult
    }

    function renderGraph(nodesParam?: Node[], edgesParam?: Edge[]) {
      const { nodes: nodeResult, edges: edgeResult } = addSpouseAndRerouteParents(
        nodesParam || nodesOrigin.value,
        edgesParam || edgesOrigin.value
      )
      const nodeFormat = familyTreeLayout(nodeResult, edgeResult)

      return { nodes: nodeFormat, edges: edgeResult }
    }

    function setNodeSelected(newNode: Node | null) {
      nodeSelected.value = newNode
    }

    function addNode(node: Node) {
      nodesOrigin.value.push(node)
    }

    function addEdge(edge: Edge) {
      edgesOrigin.value.push(edge)
    }

    // add person by relation
    function addChild(person: any) {
      const idNode = `person-${Date.now()}`
      addNode({
        ...person,
        id: idNode,
        type: 'person',
      })
      addEdge({
        id: `edge-${Date.now()}`,
        source: nodeSelected?.value?.id || '1',
        target: idNode,
        type: 'step',
        data: { relation: 'parent' },
      })
    }

    function addSpouse(person: any) {
      const idNode = `person-${Date.now()}`
      addNode({
        ...person,
        id: idNode,
        type: 'person',
      })
      addEdge({
        id: `edge-${Date.now()}`,
        source: nodeSelected?.value?.id || '1',
        target: idNode,
        type: 'step',
        data: { relation: 'spouse' },
      })
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
      nodesOrigin,
      edgesOrigin,
      selectedNodeId,
      nodeSelected,

      // getters
      nodeCount,
      formatGraph,
      // actions
      initStore,
      setNodeSelected,
      addNode,
      addEdge,
      updateNodePosition,
      selectNode,
      renderGraph,

      addChild,
      addSpouse,
    }
  },
  {
    persist: {
      storage: sessionStorage,
      pick: ['nodes', 'edges'],
    },
  }
)
