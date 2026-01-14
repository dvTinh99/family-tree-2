<script setup>
import { h, onMounted, ref, nextTick } from 'vue'
import { Background } from '@vue-flow/background'
import { MarkerType, useVueFlow, VueFlow } from '@vue-flow/core'
import PersonNode from '@/components/nodes/PersonNode.vue'

const nodes = ref([
  {
    id: '1',
    type: 'person',
    label: 'Parent A',
    position: { x: 0, y: 0 },
    data: { name: 'Parent A' },
  },
  { id: '2', type: 'person', label: 'Parent B', position: { x: 180, y: 0 }, data: { name: 'Parent B' } },
  { id: '3', type: 'person', label: 'Child', position: { x: 0, y: 180 }, data: { name: 'Child' } },
])
const edges = ref([
  {
    id: 'e1',
    source: '1',
    target: '2',
    type: 'step',
    data: { relation: 'husband' },
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
    source: '2',
    target: '3',
    type: 'step',
    data: { relation: 'parent' },
    sourceHandle: 'bottom-source',
    targetHandle: 'top-target',
  },
])

const { fitView } = useVueFlow()

function layoutFamily(nodes, edges) {
  // Copy so we don’t mutate original directly
  const newNodes = nodes.value.map((n) => ({ ...n, position: { ...(n.position || { x: 0, y: 0 }) } }))

  // Build parent/children maps and spouse map
  const parentsOf = {}   // childId -> [parentIds]
  const childrenOf = {}  // parentId -> [childIds]
  const spouseMap = {}   // nodeId -> [spouseIds]

  edges.value.forEach((e) => {
    const rel = e.data?.relation || ''
    if (rel === 'parent') {
      parentsOf[e.target] = parentsOf[e.target] || []
      parentsOf[e.target].push(e.source)
      childrenOf[e.source] = childrenOf[e.source] || []
      childrenOf[e.source].push(e.target)
    } else if (rel === 'spouse' || rel === 'husband' || rel === 'wife' || rel === 'partner') {
      spouseMap[e.source] = spouseMap[e.source] || []
      spouseMap[e.source].push(e.target)
      spouseMap[e.target] = spouseMap[e.target] || []
      spouseMap[e.target].push(e.source)
    }
  })

  // Identify root parents (no incoming parent edges)
  const allIds = newNodes.map((n) => n.id)
  const hasParent = new Set(Object.keys(parentsOf).flatMap((k) => parentsOf[k] || [])) // not used directly
  const roots = newNodes.filter((n) => !(parentsOf[n.id] && parentsOf[n.id].length > 0))

  // Layout roots centered around x = 0 (center of canvas)
  const spacingX = 220
  const spacingY = 160
  const yRoot = 0
  const totalRoots = roots.length || 1
  const startX = -((totalRoots - 1) * spacingX) / 2
  roots.forEach((node, i) => {
    node.position.x = startX + i * spacingX
    node.position.y = yRoot
  })

  // BFS to assign levels (distance from any root using parent->child edges)
  const levels = new Map()
  const q = []
  roots.forEach((r) => {
    levels.set(r.id, 0)
    q.push(r.id)
  })
  while (q.length) {
    const id = q.shift()
    const lvl = levels.get(id)
    const childs = childrenOf[id] || []
    childs.forEach((c) => {
      const desired = lvl + 1
      if (!levels.has(c) || levels.get(c) < desired) {
        levels.set(c, desired)
        q.push(c)
      }
    })
  }
  // ensure every node has a level
  newNodes.forEach((n) => { if (!levels.has(n.id)) levels.set(n.id, 0) })

  // Group node ids by level
  const levelMap = new Map()
  newNodes.forEach((n) => {
    const lvl = levels.get(n.id)
    if (!levelMap.has(lvl)) levelMap.set(lvl, [])
    levelMap.get(lvl).push(n.id)
  })

  // For each level, compute ordering (try to keep spouses adjacent)
  for (const [lvl, ids] of levelMap.entries()) {
    const placed = new Set()
    const ordered = []
    ids.forEach((id) => {
      if (placed.has(id)) return
      const partner = (spouseMap[id] || []).find((p) => ids.includes(p) && !placed.has(p))
      if (partner) {
        ordered.push(id, partner)
        placed.add(id); placed.add(partner)
      } else {
        ordered.push(id); placed.add(id)
      }
    })

    // center this level around x=0 (so overall tree is centered)
    const count = ordered.length
    const levelStartX = -((count - 1) * spacingX) / 2

    ordered.forEach((nodeId, idx) => {
      const node = newNodes.find((n) => n.id === nodeId)
      if (!node) return

      // default grid position for this level
      const gridX = levelStartX + idx * spacingX
      const gridY = lvl * spacingY

      const parents = parentsOf[nodeId] || []

      if (parents.length >= 2) {
        // center under multiple parents (e.g., mom + dad)
        const parentXs = parents.map((pid) => newNodes.find((n) => n.id === pid)?.position?.x ?? 0)
        node.position.x = parentXs.reduce((a, b) => a + b, 0) / parentXs.length
        node.position.y = (Math.max(...parents.map((pid) => newNodes.find((n) => n.id === pid)?.position?.y ?? (lvl - 1) * spacingY)) + spacingY)
      } else if (parents.length === 1) {
        // single parent: if that parent has a spouse, center between parent and spouse
        const pId = parents[0]
        const spouse = (spouseMap[pId] || []).find((s) => allIds.includes(s))
        if (spouse) {
          const pX = newNodes.find((n) => n.id === pId)?.position?.x ?? gridX
          const sX = newNodes.find((n) => n.id === spouse)?.position?.x ?? pX
          node.position.x = (pX + sX) / 2
        } else {
          node.position.x = newNodes.find((n) => n.id === pId)?.position?.x ?? gridX
        }
        node.position.y = (newNodes.find((n) => n.id === pId)?.position?.y ?? (lvl - 1) * spacingY) + spacingY
      } else {
        // no parents (unlikely here) — use grid
        node.position.x = gridX
        node.position.y = gridY
      }
    })
  }

  return newNodes
}


onMounted(async () => {
  // compute and apply layout
  nodes.value = layoutFamily(nodes, edges)
  console.log('nodes.value', nodes.value);

//   await nextTick()
//   try { await fitView({ padding: 0.12 }) } catch (e) { /* ignore if not mounted */ }
})
</script>

<template>
  <div class="h-screen w-screen">
    <VueFlow :nodes="nodes" :edges="edges" fit-view-on-init>
      <template #node-person>
        <PersonNode />
      </template>
      <Background />
    </VueFlow>
  </div>
</template>
