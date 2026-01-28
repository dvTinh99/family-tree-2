import { nextTick } from 'vue'
import type { Ref } from 'vue'
import { useVueFlow } from '@vue-flow/core'

export function useLayout(nodes: Ref<any[]>, edges: Ref<any[]>) {
  const { fitView } = useVueFlow()

  function applyHierarchyLayout(nodesArr: any[], edgesArr: any[], hSpacing = 220, vSpacing = 140) {
    const idToNode = new Map(nodesArr.map((n) => [n.id, { ...n }]))

    const incoming = new Map()
    const outgoing = new Map()
    edgesArr.forEach((e) => {
      incoming.set(e.target, (incoming.get(e.target) || 0) + 1)
      outgoing.set(e.source, (outgoing.get(e.source) || []).concat(e.target))
    })

    let roots = nodesArr.filter((n) => !incoming.has(n.id)).map((n) => n.id)
    if (roots.length === 0 && nodesArr.length > 0) roots = [nodesArr[0].id]

    const levels = new Map()
    const q: string[] = []
    roots.forEach((r) => {
      levels.set(r, 0)
      q.push(r)
    })
    while (q.length) {
      const id = q.shift() as string
      const lvl = levels.get(id)!
      const children = outgoing.get(id) || []
      children.forEach((c: string) => {
        if (!levels.has(c)) {
          levels.set(c, lvl + 1)
          q.push(c)
        }
      })
    }

    nodesArr.forEach((n) => {
      if (!levels.has(n.id)) levels.set(n.id, 0)
    })

    const levelMap = new Map<number, string[]>()
    nodesArr.forEach((n) => {
      const lvl = levels.get(n.id) as number
      if (!levelMap.has(lvl)) levelMap.set(lvl, [])
      levelMap.get(lvl)!.push(n.id)
    })

    for (const [lvl, ids] of levelMap.entries()) {
      const count = ids.length
      ids.forEach((nodeId, idx) => {
        const x = (idx - (count - 1) / 2) * hSpacing
        const y = lvl * vSpacing
        const node = idToNode.get(nodeId)
        if (node) node.position = { x, y }
      })
    }

    return Array.from(idToNode.values())
  }

  async function resetLayout() {
    nodes.value = applyHierarchyLayout(nodes.value, edges.value)
    await nextTick()
    fitView({ padding: 0.12 })
  }

  return { applyHierarchyLayout, resetLayout }
}
