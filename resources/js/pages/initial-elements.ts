import { MarkerType } from '@vue-flow/core'

export const nodesInit = [
  // Generation 0 (great-great-grandparents)
  { id: 'p1', type: 'person', label: 'GG-Grandpa', position: { x: 300, y: 0 } },
  { id: 'p2', type: 'person', label: 'GG-Grandma', position: { x: 500, y: 0 } },

  // Generation 1 (great-grandparents)
  { id: 'p3', type: 'person', label: 'G-Grandpa', position: { x: 300, y: 140 } },
  { id: 'p4', type: 'person', label: 'G-Grandma', position: { x: 500, y: 140 } },

  // Generation 2 (grandparents)
  { id: 'p5', type: 'person', label: 'Grandpa', position: { x: 200, y: 300 } },
  { id: 'p6', type: 'person', label: 'Grandma', position: { x: 400, y: 300 } },
  // sibling branch in same generation
  { id: 'p7', type: 'person', label: 'Granduncle', position: { x: 600, y: 300 } },

  // Generation 3 (parents)
  { id: 'p8', type: 'person', label: 'Father', position: { x: 200, y: 460 } },
  { id: 'p9', type: 'person', label: 'Mother', position: { x: 340, y: 460 } },

  // Generation 4 (children)
  { id: 'p10', type: 'person', label: 'Child 1', position: { x: 140, y: 620 } },
  { id: 'p11', type: 'person', label: 'Child 2', position: { x: 260, y: 620 } },
  { id: 'p12', type: 'person', label: 'Child 3', position: { x: 380, y: 620 } },
]

export const edgesInit = [
  // Generation 0 -> Generation 1 (parent relationships)
  { id: 'e1', source: 'p1', target: 'p3', type: 'step', data: { relation: 'parent' } },
  { id: 'e2', source: 'p2', target: 'p3', type: 'step', data: { relation: 'parent' } },

//   { id: 'e3', source: 'p1', target: 'p4', type: 'step', data: { relation: 'parent' } },
//   { id: 'e4', source: 'p2', target: 'p4', type: 'step', data: { relation: 'parent' } },

//   // Generation 1 -> Generation 2
//   { id: 'e5', source: 'p3', target: 'p5', type: 'step', data: { relation: 'parent' } },
//   { id: 'e6', source: 'p4', target: 'p5', type: 'step', data: { relation: 'parent' } },

//   { id: 'e7', source: 'p3', target: 'p7', type: 'step', data: { relation: 'parent' } },
//   { id: 'e8', source: 'p4', target: 'p7', type: 'step', data: { relation: 'parent' } },

//   // Generation 2 spouse connection (p5 <-> p6)
//   { id: 'e9', source: 'p5', target: 'p6', type: 'step', data: { relation: 'spouse' }, markerEnd: MarkerType.ArrowClosed },

//   // Generation 2 -> Generation 3 (parents)
//   { id: 'e10', source: 'p5', target: 'p8', type: 'step', data: { relation: 'parent' } },
//   { id: 'e11', source: 'p6', target: 'p8', type: 'step', data: { relation: 'parent' } },

//   // Generation 3 spouse connection (p8 <-> p9)
//   { id: 'e12', source: 'p8', target: 'p9', type: 'step', data: { relation: 'spouse' }, markerEnd: MarkerType.ArrowClosed },

//   // Generation 3 -> Generation 4 (children)
//   { id: 'e13', source: 'p8', target: 'p10', type: 'step', data: { relation: 'parent' } },
//   { id: 'e14', source: 'p9', target: 'p10', type: 'step', data: { relation: 'parent' } },

//   { id: 'e15', source: 'p8', target: 'p11', type: 'step', data: { relation: 'parent' } },
//   { id: 'e16', source: 'p9', target: 'p11', type: 'step', data: { relation: 'parent' } },

//   { id: 'e17', source: 'p8', target: 'p12', type: 'step', data: { relation: 'parent' } },
//   { id: 'e18', source: 'p9', target: 'p12', type: 'step', data: { relation: 'parent' } },
]
