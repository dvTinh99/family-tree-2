import { defineStore } from 'pinia'
import { ref, computed, watch } from 'vue'
import type { Node, Edge } from '@vue-flow/core'
import { useApi } from '@/composables/useApi'
import {
  familyTreeLayout,
  addSpouseAndRerouteParents,
  applyRelationHandles,
} from '@/utils/familyTreeLayout'

export const useFamilyStore = defineStore(
  'family',
  () => {
    // state
    const nodesOrigin = ref<Node[]>([
      {
        id: '1',
        type: 'person',
        label: 'GrandFather',
        data: { name: 'GrandFather', avatar: 'images/grandfather.svg' },
      },
      {
        id: '2',
        type: 'person',
        label: 'GrandMother',
        data: { name: 'GrandMother', avatar: 'images/grandmother.svg' },
      },
      {
        id: '1.1',
        type: 'person',
        label: 'GrandFather',
        data: { name: 'GrandFather', avatar: 'images/ong_ngoai.svg' },
      },
      {
        id: '2.1',
        type: 'person',
        label: 'GrandMother',
        data: { name: 'GrandMother', avatar: 'images/ba_ngoai.svg' },
      },
      {
        id: '3',
        type: 'person',
        label: 'Father',
        data: { name: 'Father', avatar: 'images/father.svg' },
      },
      {
        id: '4',
        type: 'person',
        label: 'Mother',
        data: { name: 'Mother', avatar: 'images/mother.svg' },
      },
      {
        id: '5',
        type: 'person',
        label: 'Me',
        data: { name: 'Me', avatar: 'images/me.jpeg' },
      },
      {
        id: '6',
        type: 'person',
        label: 'Sister',
        data: { name: 'Sister', avatar: 'images/sister.svg' },
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
        id: 'e11',
        source: '1.1',
        target: '2.1',
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
        source: '1.1',
        target: '4',
        type: 'step',
        data: { relation: 'parent' },
        sourceHandle: 'bottom-source',
        targetHandle: 'top-target',
      },
      {
        id: 'e4',
        source: '3',
        target: '4',
        type: 'step',
        data: { relation: 'spouse' },
        sourceHandle: 'right-source',
        targetHandle: 'left-target',
      },
      {
        id: 'e5',
        source: '3',
        target: '5',
        type: 'step',
        data: { relation: 'parent' },
        sourceHandle: 'bottom-source',
        targetHandle: 'top-target',
      },
      {
        id: 'e6',
        source: '3',
        target: '6',
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
    const formatGraph = computed(() => {
      // if (!nodeSelected.value) return renderGraph()

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
    watch(nodeSelected, () => recountNodeAndEdges())

    function recountNodeAndEdges() {
      nodes.value = formatGraph.value.nodes
      edges.value = formatGraph.value.edges
    }

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
      nodesOrigin.value = nodeResult
      edgesOrigin.value = edgeResult
    }

    function renderGraph(nodesParam?: Node[], edgesParam?: Edge[]) {
      const { nodes: nodeResult, edges: edgeResult } = addSpouseAndRerouteParents(
        nodesParam || nodesOrigin.value,
        edgesParam || edgesOrigin.value
      )
      const nodeFormat = familyTreeLayout(nodeResult, edgeResult)

      return { nodes: nodeFormat, edges: edgeResult }
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
      addNode,
      addEdge,
      updateNodePosition,
      setNodeSelected,
      renderGraph,

      addChild,
      addSpouse,
    }
  },
  {
    persist: {
      storage: sessionStorage,
      pick: ['nodesOrigin', 'edgesOrigin'],
    },
  }
)
