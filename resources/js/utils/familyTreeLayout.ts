import dagre from '@dagrejs/dagre'
import type { Edge, Node } from '@vue-flow/core'
/**
 * Generate positioned nodes for a simple family tree.
 * Ensures spouse pairs have gap and single child sits between parents.
 * @param {Array} nodes – list of nodes
 * @param {Array} relation – list of relationships
 */
export function familyTreeLayout(nodes: Node[], relation: Edge[]) {
  const g = new dagre.graphlib.Graph()
  g.setDefaultEdgeLabel(() => ({}))

  // Config spacing
  const spouseGap = 100
  const defaultNodeWidth = 180
  const defaultNodeHeight = 90

  g.setGraph({
    rankdir: 'TB', // top to bottom
    ranksep: 100, // vertical spacing
    nodesep: 80, // horizontal spacing
  })

  // Build map
  const nodeMap = {} as any
  nodes.forEach((n) => {
    nodeMap[n.id] = { ...n }
    g.setNode(n.id, {
      width: defaultNodeWidth,
      height: defaultNodeHeight,
    })
  })

  // Edges: only parent->child for Dagre
  relation.forEach((e) => {
    if (e.data?.relation === 'parent') {
      g.setEdge(e.source, e.target)
    }
  })

  // Layout with Dagre
  dagre.layout(g)

  // Read positions
  const layouted = nodes.map((n) => {
    const point = g.node(n.id)
    return {
      ...n,
      position: {
        x: point.x - defaultNodeWidth / 2,
        y: point.y - defaultNodeHeight / 2,
      },
    }
  })

  // Post-process: enforce spouse pair gaps & center single child
  const spouses = relation
    .filter((e) => e.data?.relation === 'spouse')
    .map((e) => [e.source, e.target])

  spouses.forEach(([a, b]) => {
    const nodeA = layouted.find((x) => x.id === a)
    const nodeB = layouted.find((x) => x.id === b)
    if (!nodeA || !nodeB) return

    // adjust gap if too small
    const mid = (nodeA.position.x + nodeB.position.x) / 2
    const currentGap = Math.abs(nodeA.position.x - nodeB.position.x)
    if (currentGap < spouseGap) {
      nodeA.position.x = mid - spouseGap / 2
      nodeB.position.x = mid + spouseGap / 2
    }

    // find children for both parents
    const children = relation
      .filter(
        (e) =>
          e.data?.relation === 'parent' &&
          (e.source === a || e.source === b) &&
          relation.some(
            (ee) =>
              ee.data?.relation === 'parent' &&
              (ee.source === a || ee.source === b) &&
              ee.target === e.target
          )
      )
      .map((e) => e.target)

    // If exactly 1 child, put child between parents
    if (children.length === 1) {
      const childNode = layouted.find((x) => x.id === children[0])
      if (childNode) {
        childNode.position.x = mid - defaultNodeWidth / 2
      }
    }
  })

  return layouted
}

export function applyRelationHandles(edges: Edge[]) {
  return edges.map((edge) => {
    if (edge.data?.relation === 'spouse') {
      return {
        ...edge,
        sourceHandle: 'right-source',
        targetHandle: 'left-target',
      }
    } else if (edge.data?.relation === 'parent') {
      return {
        ...edge,
        sourceHandle: 'bottom-source',
        targetHandle: 'top-target',
      }
    }
    return edge
  })
}
