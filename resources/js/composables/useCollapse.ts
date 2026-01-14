import { ref } from 'vue'
import type { Ref } from 'vue'
import { nextTick } from 'vue'
import { useVueFlow } from '@vue-flow/core'

export function useCollapse(nodes: Ref<any[]>, edges: Ref<any[]>) {
  const collapsedMap = ref(new Map<string, { nodes: any[]; edges: any[]; summaryId: string }>())
  const { fitView } = useVueFlow()

  function getDescendants(startId: string) {
    const out = new Set<string>()
    const q = [startId]
    while (q.length) {
      const cur = q.shift()!
      edges.value.forEach((e) => {
        if (e.source === cur && !out.has(e.target) && e.target !== startId) {
          out.add(e.target); q.push(e.target)
        }
      })
    }
    out.delete(startId)
    return Array.from(out)
  }

  function collapseBranch(parentId: string) {
    if (collapsedMap.value.has(parentId)) return
    const descIds = getDescendants(parentId)
    if (descIds.length === 0) return

    const snapshotNodes = nodes.value.filter((n) => descIds.includes(n.id))
    const snapshotEdges = edges.value.filter((e) => descIds.includes(e.source) || descIds.includes(e.target))

    nodes.value = nodes.value.filter((n) => !descIds.includes(n.id))
    edges.value = edges.value.filter((e) => !(descIds.includes(e.source) || descIds.includes(e.target)))

    const summaryId = `collapsed-${parentId}-${Date.now().toString().slice(-4)}`
    const parent = nodes.value.find((n) => n.id === parentId) || { position: { x: 0, y: 0 } }
    const summaryPos = { x: (parent.position?.x || 0) + 80, y: (parent.position?.y || 0) + 220 }

    nodes.value.push({
      id: summaryId,
      type: 'person',
      position: summaryPos,
      data: { name: `+${descIds.length} collapsed`, _isSummary: true, _count: descIds.length },
    })

    edges.value.push({
      id: `e-${parentId}-${summaryId}`,
      source: parentId, target: summaryId, type: 'smoothstep', data: { relation: 'collapsed' },
      sourceHandle: 'bottom-source', targetHandle: 'top-target',
    })

    nodes.value = nodes.value.map((n) => (n.id === parentId ? { ...n, data: { ...(n.data || {}), _collapsed: true } } : n))
    collapsedMap.value.set(parentId, { nodes: snapshotNodes, edges: snapshotEdges, summaryId })
    nextTick().then(() => fitView({ padding: 0.12 }))
  }

  function expandBranch(parentId: string) {
    const snap = collapsedMap.value.get(parentId)
    if (!snap) return
    nodes.value = nodes.value.filter((n) => n.id !== snap.summaryId)
    edges.value = edges.value.filter((e) => !(e.source === parentId && e.target === snap.summaryId))

    nodes.value = nodes.value.concat(snap.nodes)
    edges.value = edges.value.concat(snap.edges)

    nodes.value = nodes.value.map((n) => (n.id === parentId ? { ...n, data: { ...(n.data || {}), _collapsed: false } } : n))

    collapsedMap.value.delete(parentId)
    nextTick().then(() => fitView({ padding: 0.12 }))
  }

  function toggleBranch(parentId: string) {
    if (collapsedMap.value.has(parentId)) expandBranch(parentId)
    else collapseBranch(parentId)
  }

  return { collapseBranch, expandBranch, toggleBranch, getDescendants, collapsedMap }
}
