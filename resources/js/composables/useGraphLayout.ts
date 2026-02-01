import dagre from '@dagrejs/dagre'
import { Position, useVueFlow } from '@vue-flow/core'

export function useFamilyTreeLayout() {
  const { findNode } = useVueFlow()

  function buildGraph(persons, relations) {
    const dagreGraph = new dagre.graphlib.Graph()
    dagreGraph.setDefaultEdgeLabel(() => ({}))

    // spacing tốt giữa generations
    dagreGraph.setGraph({
      rankdir: 'TB',
      ranksep: 110,
      nodesep: 60,
    })

    const nodes = []
    const edges = []

    // map for marriage nodes
    const marriageMap = {}

    // xử lý persons thành nodes
    persons.forEach((p) => {
      nodes.push({ id: p.id.toString(), data: p, type: 'person' })
    })

    // build relations
    relations.forEach((r) => {
      // nếu có partner/spouse
      if (r.type === 'spouse') {
        const husband = r.sourceId.toString()
        const wife = r.targetId.toString()
        const marriageId = `m-${husband}-${wife}`

        // tạo marriage node ảo nếu chưa có
        if (!marriageMap[marriageId]) {
          marriageMap[marriageId] = true
          nodes.push({
            id: marriageId,
            type: 'marriage',
            data: {},
          })

          // nối vợ/chồng tới marriage node
          edges.push({ source: husband, target: marriageId })
          edges.push({ source: wife, target: marriageId })
        }
      }
    })

    // xử lý quan hệ parent → child
    relations.forEach((r) => {
      if (r.type === 'parent') {
        const parent = r.sourceId.toString()
        const child = r.targetId.toString()

        // tìm marriage node nếu parent có partner
        const mKey = Object.keys(marriageMap).find((mid) => mid.includes(parent))
        if (mKey) {
          edges.push({ source: mKey, target: child })
        } else {
          edges.push({ source: parent, target: child })
        }
      }
    })

    return { dagreGraph, nodes, edges }
  }

  function layout(persons, relations) {
    console.log('persons, relations in layout', persons, relations)

    const { dagreGraph, nodes, edges } = buildGraph(persons, relations)

    // add to graph
    nodes.forEach((n) => {
      // findNode gives dimensions
      const gnode = findNode(n.id)
      dagreGraph.setNode(n.id, {
        width: gnode?.dimensions.width || 150,
        height: gnode?.dimensions.height || 60,
      })
    })

    edges.forEach((e) => {
      dagreGraph.setEdge(e.source, e.target)
    })

    dagre.layout(dagreGraph)

    const layouted = nodes.map((n) => {
      const pos = dagreGraph.node(n.id)
      return {
        id: n.id,
        type: n.type,
        data: n.data,
        position: {
          x: pos.x - pos.width / 2,
          y: pos.y - pos.height / 2,
        },
      }
    })

    return { nodes: layouted, edges }
  }

  return { layout }
}
