import dagre from 'dagre'
import { Node } from '@vue-flow/core'

const NODE_WIDTH = 180
const NODE_HEIGHT = 90
const LEVEL_GAP = 120

/**
 * Tạo layout tự động theo thế hệ
 * @param nodes VueFlow Nodes
 * @param edges VueFlow Edges
 * @returns new nodes with calculated position
 */
export function layoutFamilyTree<T = any>(
  nodes: Node<T>[],
  edges: { source: string; target: string }[]
): Node<T>[] {
  const g = new dagre.graphlib.Graph()
  g.setDefaultEdgeLabel(() => ({}))
  g.setGraph({
    rankdir: 'TB',
    nodesep: 40,
    ranksep: LEVEL_GAP,
  })

  nodes.forEach(node => {
    g.setNode(node.id, {
      width: NODE_WIDTH,
      height: NODE_HEIGHT,
    })
  })

  edges.forEach(edge => {
    g.setEdge(edge.source, edge.target)
  })

  dagre.layout(g)

  return nodes.map(node => {
    const { x, y } = g.node(node.id)
    return {
      ...node,
      position: {
        x: x - NODE_WIDTH / 2,
        y: y - NODE_HEIGHT / 2,
      },
      draggable: false,
    }
  })
}
