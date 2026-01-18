import dagre from '@dagrejs/dagre'
import type { Edge, Node } from '@vue-flow/core'
/**
 * Generate positioned nodes and updated edges for a simple family tree.
 * Creates spouse nodes for couples and connects children to the spouse node.
 * @param {Array} nodes – list of nodes
 * @param {Array} relation – list of relationships
 */
export function familyTreeLayout(nodes: Node[], relation: Edge[]): { nodes: Node[], edges: Edge[]} {
  const g = new dagre.graphlib.Graph()
  g.setDefaultEdgeLabel(() => ({}))

  // Config spacing
  const spouseGap = 100
  const defaultNodeWidth = 200
  const defaultNodeHeight = 90

  g.setGraph({
    rankdir: 'TB', // top to bottom
    ranksep: 100, // vertical spacing
    nodesep: 80, // horizontal spacing
  })

  // Identify spouse pairs
  const spouses = relation
    .filter((e) => e.data?.relation === 'spouse')
    .map((e) => [e.source, e.target].sort()) // sort to ensure consistent order

    console.log('spouses', spouses);
    

  // Create new nodes and edges
  let newNodes = [...nodes]
  let newEdges = [...relation]

  spouses.forEach(([a, b]) => {
    const spouseId = `spouse-${a}-${b}`
    // Add spouse node
    newNodes.push({
      id: spouseId,
      type: 'spouse',
      data: {},
      position: { x: 0, y: 0 }, // will be set later
    })

    // Add edges from spouses to spouse node
    newEdges.push({
      id: `edge-${a}-to-${spouseId}`,
      source: a,
      target: spouseId,
      data: { relation: 'spouse-link' },
      targetHandle: 'left-target',
    })
    newEdges.push({
      id: `edge-${b}-to-${spouseId}`,
      source: b,
      target: spouseId,
      data: { relation: 'spouse-link' },
      targetHandle: 'right-target',
    })

    // Find children of this couple
    const children = relation
      .filter((e) => e.data?.relation === 'parent' && (e.source === a || e.source === b))
      .map((e) => e.target)

    console.log('children', children);
    
    // Remove original parent edges
    newEdges = newEdges.filter(
      (e) => !(e.data?.relation === 'parent' && (e.source === a || e.source === b))
    )

    // Add new parent edges from spouse node to children
    children.forEach((child) => {
      newEdges.push({
        id: `edge-${spouseId}-to-${child}`,
        source: spouseId,
        target: child,
        data: { relation: 'parent' },
      })
    })

    // Remove original spouse edge
    newEdges = newEdges.filter(
      (e) =>
        !(
          e.data?.relation === 'spouse' &&
          ((e.source === a && e.target === b) || (e.source === b && e.target === a))
        )
    )
  })

  // Build map and set nodes in graph
  const nodeMap = {} as any
  newNodes.forEach((n) => {
    nodeMap[n.id] = { ...n }
    g.setNode(n.id, {
      width: defaultNodeWidth,
      height: defaultNodeHeight,
    })
  })

  // Edges: only parent->child for Dagre
  newEdges.forEach((e) => {
    if (e.data?.relation === 'parent') {
      g.setEdge(e.source, e.target)
    }
  })

  // Layout with Dagre
  dagre.layout(g)

  // Read positions
  const layouted = newNodes.map((n) => {
    const point = g.node(n.id)
    console.log('point', point);
    
    return {
      ...n,
      position: {
        x: point.x - defaultNodeWidth / 2,
        y: point.y - defaultNodeHeight / 2,
      },
    }
  })

  // Post-process: position spouse nodes and adjust spouse positions
  spouses.forEach(([a, b]) => {
    const spouseId = `spouse-${a}-${b}`
    const nodeA = layouted.find((x) => x.id === a)
    const nodeB = layouted.find((x) => x.id === b)
    const spouseNode = layouted.find((x) => x.id === spouseId)
    if (!nodeA || !nodeB || !spouseNode) return

    // Adjust spouse positions with gap
    const currentGap = Math.abs(nodeA.position.x - nodeB.position.x)
    const midX = (nodeA.position.x + nodeB.position.x) / 2
    if (currentGap < spouseGap) {
      nodeA.position.x = midX - spouseGap / 2
      nodeB.position.x = midX + spouseGap / 2
    }

    // Now position spouse node at the center
    const newMidX = (nodeA.position.x + nodeB.position.x) / 2
    console.log('newMidX', newMidX);
    
    const newMidY = (nodeA.position.y + nodeB.position.y) / 2
    console.log('newMidY', newMidY);

    spouseNode.position.x = newMidX - defaultNodeWidth / 2
    spouseNode.position.y = newMidY > 0 ? newMidY / 2 : newMidY
  })

  console.log('layouted', layouted);
  console.log('edges', newEdges);
  

  return { nodes: layouted, edges: newEdges }
}

export function familyTreeLayout2(
  nodes: Node[],
  edges: Edge[],
  direction: "TB" | "LR" = "TB"
): Node[] {
  console.log('node before', nodes);
  console.log('edge before', edges);
  
  // 1) Initialize Dagre graph
  const g = new dagre.graphlib.Graph();
  g.setDefaultEdgeLabel(() => ({}));

  const isHorizontal = direction === "LR";

  g.setGraph({
    rankdir: direction,
    ranksep: 120,  // vertical spacing between generations
    nodesep: 80,   // horizontal spacing between nodes
  });

  const DEFAULT_W = 180;
  const DEFAULT_H = 80;

  // 2) Add nodes to dagre graph
  nodes.forEach((n) => {
    g.setNode(n.id, {
      width: n.__rf?.width ?? DEFAULT_W,
      height: n.__rf?.height ?? DEFAULT_H,
    });
  });

  // 3) Add edges (parent → child direction)
  edges.forEach((e) => {
    // Only include layout relevant edges
    // spouse nodes already serve as intermediate
    if (e.data?.relation === "parent") {
      g.setEdge(e.source, e.target);
    }
  });

  // 4) Compute layout
  dagre.layout(g);

  g.nodes().forEach(function(v) {
      console.log("Node " + v + ": " + JSON.stringify(g.node(v)));
  });
  g.edges().forEach(function(e) {
      console.log("Edge " + e.v + " -> " + e.w + ": " + JSON.stringify(g.edge(e)));
  });

  // 5) Map positions back to nodes
  const layouted = nodes.map((n) => {
    const { x, y } = g.node(n.id); // center coords
    return {
      ...n,
      position: {
        // adjust to top-left (Vue Flow expects top-left position)
        // x: x - (n.__rf?.width ?? DEFAULT_W) / 2,
        // y: y - (n.__rf?.height ?? DEFAULT_H) / 2,
        x,
        y
      },
    };
  });

  return layouted;
}


export function applyRelationHandles(edges: Edge[]) {
  return edges.map((edge) => {
    if (edge.data?.relation === 'spouse-link') {
      return {
        ...edge,
        sourceHandle: 'center-source',
        type: 'smoothstep',
        style: edge.style
      }
    } else if (edge.data?.relation === 'parent') {
      return {
        ...edge,
        sourceHandle: 'bottom-source',
        targetHandle: 'top-target',
        style: edge.style
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
  const newNodes: Node[] = [...nodes];
  const newEdges: Edge[] = [];
  const seenSpousePairs = new Set<string>();

  // map: parentId -> spouseNodeId
  const parentToSpouseNode: Record<string, string> = {};

  // 1) Create spouse nodes
  edges.forEach((e) => {
    if (e.data?.relation === "spouse") {
      const a = e.source;
      const b = e.target;

      // stable key for pair
      const key = [a, b].sort().join("|");
      if (!seenSpousePairs.has(key)) {
        seenSpousePairs.add(key);

        const marriageId = `spouse-${a}-${b}`;

        const idx = nodes.findIndex((item) => item.id == a)
        // create invisible spouse node
        newNodes.splice(idx + 1, 0, {
          id: marriageId,
          type: "spouse",
          position: { x: 0, y: 0 },
          data: {},
          // style: { opacity: 0, pointerEvents: "none" },
        });

        // set map both directions
        parentToSpouseNode[a] = marriageId;
        parentToSpouseNode[b] = marriageId;

        // add edge parent → spouseNode
        newEdges.push({
          id: `spouse-${a}-${marriageId}`,
          source: a,
          target: marriageId,
          type: "step",
          data: { relation: "spouse" },
          sourceHandle: 'right-source',
          targetHandle: 'left-target',
        });
        newEdges.push({
          id: `spouse-${b}-${marriageId}`,
          source: marriageId,
          target: b,
          type: "step",
          data: { relation: "spouse" },
          sourceHandle: 'right-source',
          targetHandle: 'left-target',
        });
      }
    }
  });

  // 2) Reroute parent → child edges
  edges.forEach((e) => {
    // ignore original spouse edges — we already made new ones
    if (e.data?.relation === "spouse") {
      return;
    }

    if (e.data?.relation === "parent") {
      const parentId = e.source;
      const childId = e.target;

      // find spouse node if exists
      const spouseNode = parentToSpouseNode[parentId];

      if (spouseNode) {
        // route: spouseNode → child
        newEdges.push({
          ...e, // preserve id/type/data except source
          source: spouseNode,
          target: childId,
        });
      } else {
        // no spouse, keep parent as source
        newEdges.push(e);
      }
    } else {
      // keep other edge types as is
      newEdges.push(e);
    }
  });

  return { nodes: newNodes, edges: newEdges };
}
