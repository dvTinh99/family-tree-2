import dagre from 'dagre'
import type { Node, Edge } from '@vue-flow/core'

const NODE_WIDTH = 180
const NODE_HEIGHT = 90
const RANK_SEP = 100

export function applyLayout(nodes: Node[], edges: Edge[]): { nodes: Node[]; edges: Edge[] } {
  const g = new dagre.graphlib.Graph()
  g.setGraph({ rankdir: 'TB', nodesep: 50, ranksep: RANK_SEP })
  g.setDefaultEdgeLabel(() => ({}))

  nodes.forEach((n) => {
    g.setNode(n.id, { width: NODE_WIDTH, height: NODE_HEIGHT })
  })
  edges.forEach((e) => {
    g.setEdge(e.source, e.target)
  })

  dagre.layout(g)

  const laidOutNodes = nodes.map((n) => {
    const { x, y } = g.node(n.id)!
    return {
      ...n,
      position: { x: x - NODE_WIDTH / 2, y: y - NODE_HEIGHT / 2 },
      // 👉 DRAGGABLE stays true
    }
  })

  return { nodes: laidOutNodes, edges }
}
