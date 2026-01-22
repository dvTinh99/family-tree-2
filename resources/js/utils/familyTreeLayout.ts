import dagre from '@dagrejs/dagre'
import type { Edge, Node } from '@vue-flow/core'
/**
 * Generate positioned nodes and updated edges for a simple family tree.
 * Creates spouse nodes for couples and connects children to the spouse node.
 * @param {Array} nodes – list of nodes
 * @param {Array} relation – list of relationships
 */
export function familyTreeLayout(
  nodes: Node[],
  edges: Edge[],
  direction: 'TB' | 'LR' = 'TB'
): Node[] {
  // 1) Initialize Dagre graph
  const g = new dagre.graphlib.Graph()
  g.setDefaultEdgeLabel(() => ({}))

  const isHorizontal = direction === 'LR'

  g.setGraph({
    rankdir: direction,
    ranksep: 50, // vertical spacing between generations
    nodesep: 100, // horizontal spacing between nodes
  })

  const DEFAULT_W = 100
  const DEFAULT_H = 50

  // 2) Add nodes to dagre graph
  nodes.forEach((n) => {
    g.setNode(n.id, {
      width: n.data?.width || DEFAULT_W,
      height: n.data?.height || DEFAULT_H,
    })
  })

  // 3) Add edges (parent → child direction)
  edges.forEach((e) => {
    // Only include layout relevant edges
    // spouse nodes already serve as intermediate
    if (e.data?.relation === 'parent') {
      g.setEdge(e.source, e.target)
    }
  })

  // 4) Compute layout
  dagre.layout(g)

  // 5) Map positions back to nodes
  const layouted = nodes.map((n) => {
    const { x, y } = g.node(n.id) // center coords
    if (n.type == 'spouse') {
      console.log('spouse ne', n);
      const [sourceId, targetId] = n.id.split('-').slice(1)
      const dadNode = g.node(sourceId)
      const momNode = g.node(targetId)
      console.log('dadNode, momNode', dadNode.x, momNode.x);
      const center = ((dadNode.x + momNode.x) / 2) + 70;

      console.log('center', center);
      
      return {
        ...n,
        position: {
          // adjust to top-left (Vue F`low expects top-left position)
          // x: x - (n.__rf?.width ?? DEFAULT_W) / 2,
          // y: y - (n.__rf?.height ?? DEFAULT_H) / 2,
          x: center,
          y,
        },
      }
    }
    return {
      ...n,
      position: {
        // adjust to top-left (Vue Flow expects top-left position)
        // x: x - (n.__rf?.width ?? DEFAULT_W) / 2,
        // y: y - (n.__rf?.height ?? DEFAULT_H) / 2,
        x,
        y,
      },
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
        type: 'smoothstep',
      }
    } else if (edge.data?.relation === 'parent') {
      return {
        ...edge,
        sourceHandle: 'bottom-source',
        targetHandle: 'top-target',
      }
    }
    return { ...edge, style: edge.style }
  })
}

/**
 * Add spouse nodes and ensure all parent edges go through spouse node.
 */
export function addSpouseAndRerouteParents(
  nodes: Node[],
  edges: Edge[]
): { nodes: Node[]; edges: Edge[] } {
  const newNodes: Node[] = [...nodes]
  const newEdges: Edge[] = []
  const seenSpousePairs = new Set<string>()

  // map: parentId -> spouseNodeId
  const parentToSpouseNode: Record<string, string> = {}

  // 1) Create spouse nodes
  edges.forEach((e) => {
    if (e.data?.relation === 'spouse') {
      const a = e.source
      const b = e.target

      // stable key for pair
      const key = [a, b].sort().join('|')
      if (!seenSpousePairs.has(key)) {
        seenSpousePairs.add(key)

        const marriageId = `spouse-${a}-${b}`

        const idx = nodes.findIndex((item) => item.id == a)
        // create invisible spouse node
        newNodes.splice(idx + 1, 0, {
          id: marriageId,
          type: 'spouse',
          position: { x: 0, y: 0 },
          data: { width: 50, height: 50 },
          // style: { opacity: 0, pointerEvents: "none" },
        })

        // set map both directions
        parentToSpouseNode[a] = marriageId
        parentToSpouseNode[b] = marriageId

        // add edge parent → spouseNode
        newEdges.push({
          id: `spouse-${a}-${marriageId}`,
          source: a,
          target: marriageId,
          type: 'smoothstep',
          data: { relation: 'parent' },
          sourceHandle: 'bottom-source',
          targetHandle: 'left-target',
        })
        newEdges.push({
          id: `spouse-${b}-${marriageId}`,
          source: b,
          target: marriageId,
          type: 'smoothstep',
          data: { relation: 'parent' },
          sourceHandle: 'bottom-source',
          targetHandle: 'right-target',
        })
      }
    }
  })

  // 2) Reroute parent → child edges
  edges.forEach((e) => {
    // ignore original spouse edges — we already made new ones
    if (e.data?.relation === 'spouse') {
      return
    }

    if (e.data?.relation === 'parent') {
      const parentId = e.source
      const childId = e.target

      // find spouse node if exists
      const spouseNode = parentToSpouseNode[parentId]

      if (spouseNode) {
        // route: spouseNode → child
        newEdges.push({
          ...e, // preserve id/type/data except source
          source: spouseNode,
          target: childId,
        })
      } else {
        // no spouse, keep parent as source
        newEdges.push(e)
      }
    } else {
      // keep other edge types as is
      newEdges.push(e)
    }
  })

  return { nodes: newNodes, edges: newEdges }
}
