import { MarkerType, Position } from '@vue-flow/core'

export const nodesInit = [
  // generation 0 (grandparents)
  {
    id: 'p1',
    type: 'person',
    label: 'Grandpa A',
    toolbarPosition: Position.Top,
    position: { x: 100, y: 0 },
    toolbarVisible: true,
  },
  {
    id: 'p2',
    type: 'person',
    label: 'Grandma A',
    toolbarPosition: Position.Top,
    position: { x: 300, y: 0 },
  },
  {
    id: 'p3',
    type: 'person',
    label: 'Grandpa B',
    toolbarPosition: Position.Top,
    position: { x: 700, y: 0 },
  },
  {
    id: 'p4',
    type: 'person',
    label: 'Grandma B',
    toolbarPosition: Position.Top,
    position: { x: 900, y: 0 },
  },

  // generation 1 (parents)
  {
    id: 'p5',
    type: 'person',
    label: 'Father 1',
    toolbarPosition: Position.Top,
    position: { x: 200, y: 160 },
  },
  {
    id: 'p6',
    type: 'person',
    label: 'Mother 1',
    toolbarPosition: Position.Top,
    position: { x: 400, y: 160 },
  },
  {
    id: 'p7',
    type: 'person',
    label: 'Father 2',
    toolbarPosition: Position.Top,
    position: { x: 600, y: 160 },
  },
  {
    id: 'p8',
    type: 'person',
    label: 'Mother 2',
    toolbarPosition: Position.Top,
    position: { x: 800, y: 160 },
  },
  {
    id: 'p9',
    type: 'person',
    label: 'Aunt',
    toolbarPosition: Position.Top,
    position: { x: 1000, y: 160 },
  },

  // generation 2 (children)
  {
    id: 'p10',
    type: 'person',
    label: 'Child 1',
    toolbarPosition: Position.Top,
    position: { x: 150, y: 320 },
  },
  {
    id: 'p11',
    type: 'person',
    label: 'Child 2',
    toolbarPosition: Position.Top,
    position: { x: 350, y: 320 },
  },
  {
    id: 'p12',
    type: 'person',
    label: 'Child 3',
    toolbarPosition: Position.Top,
    position: { x: 550, y: 320 },
  },
  {
    id: 'p13',
    type: 'person',
    label: 'Child 4',
    toolbarPosition: Position.Top,
    position: { x: 750, y: 320 },
  },
  {
    id: 'p14',
    type: 'person',
    label: 'Child 5',
    toolbarPosition: Position.Top,
    position: { x: 950, y: 320 },
  },

  // generation 2 partners / additional spouses
  {
    id: 'p15',
    type: 'person',
    label: 'Spouse 1A',
    toolbarPosition: Position.Top,
    position: { x: 250, y: 320 },
  },
  {
    id: 'p16',
    type: 'person',
    label: 'Spouse 2A',
    toolbarPosition: Position.Top,
    position: { x: 650, y: 320 },
  },

  // generation 3 (grandchildren)
  {
    id: 'p17',
    type: 'person',
    label: 'Grandchild 1',
    toolbarPosition: Position.Top,
    position: { x: 120, y: 480 },
  },
  {
    id: 'p18',
    type: 'person',
    label: 'Grandchild 2',
    toolbarPosition: Position.Top,
    position: { x: 180, y: 480 },
  },
  {
    id: 'p19',
    type: 'person',
    label: 'Grandchild 3',
    toolbarPosition: Position.Top,
    position: { x: 320, y: 480 },
  },
  {
    id: 'p20',
    type: 'person',
    label: 'Grandchild 4',
    toolbarPosition: Position.Top,
    position: { x: 420, y: 480 },
  },
  {
    id: 'p21',
    type: 'person',
    label: 'Grandchild 5',
    toolbarPosition: Position.Top,
    position: { x: 640, y: 480 },
  },
  {
    id: 'p22',
    type: 'person',
    label: 'Grandchild 6',
    toolbarPosition: Position.Top,
    position: { x: 760, y: 480 },
  },
  {
    id: 'p23',
    type: 'person',
    label: 'Grandchild 7',
    toolbarPosition: Position.Top,
    position: { x: 920, y: 480 },
  },

  // generation 3 partners
  {
    id: 'p24',
    type: 'person',
    label: 'Partner G1',
    toolbarPosition: Position.Top,
    position: { x: 200, y: 480 },
  },
  {
    id: 'p25',
    type: 'person',
    label: 'Partner G2',
    toolbarPosition: Position.Top,
    position: { x: 700, y: 480 },
  },

  // some more unrelated nodes to enlarge graph
  {
    id: 'p26',
    type: 'person',
    label: 'Cousin 1',
    toolbarPosition: Position.Top,
    position: { x: 1100, y: 320 },
  },
  {
    id: 'p27',
    type: 'person',
    label: 'Cousin 2',
    toolbarPosition: Position.Top,
    position: { x: 1100, y: 480 },
  },

  // deeper generation
  {
    id: 'p28',
    type: 'person',
    label: 'GreatGrand 1',
    toolbarPosition: Position.Top,
    position: { x: 120, y: 640 },
  },
  {
    id: 'p29',
    type: 'person',
    label: 'GreatGrand 2',
    toolbarPosition: Position.Top,
    position: { x: 180, y: 640 },
  },
  {
    id: 'p30',
    type: 'person',
    label: 'GreatGrand 3',
    toolbarPosition: Position.Top,
    position: { x: 760, y: 640 },
  },

  // extra partners to test multiple unions
  {
    id: 'p31',
    type: 'person',
    label: 'Partner A1',
    toolbarPosition: Position.Top,
    position: { x: 300, y: 160 },
  },
  {
    id: 'p32',
    type: 'person',
    label: 'Partner A2',
    toolbarPosition: Position.Top,
    position: { x: 500, y: 160 },
  },

  // random nodes
  {
    id: 'p33',
    type: 'person',
    label: 'Friend 1',
    toolbarPosition: Position.Top,
    position: { x: 400, y: 640 },
  },
  {
    id: 'p34',
    type: 'person',
    label: 'Friend 2',
    toolbarPosition: Position.Top,
    position: { x: 600, y: 640 },
  },

  // testing multiple-wife scenario: two partners for same parent
  {
    id: 'p35',
    type: 'person',
    label: 'Wife A1',
    toolbarPosition: Position.Top,
    position: { x: 450, y: 320 },
  },
  {
    id: 'p36',
    type: 'person',
    label: 'Wife A2',
    toolbarPosition: Position.Top,
    position: { x: 450, y: 480 },
  },
]

export const edgesInit = [
  // grandparents -> parents
  { id: 'e1', source: 'p1', target: 'p5', type: 'step', data: { relation: 'father' } },
  { id: 'e2', source: 'p2', target: 'p5', type: 'step', data: { relation: 'mother' } },
  { id: 'e3', source: 'p3', target: 'p7', type: 'step', data: { relation: 'father' } },
  { id: 'e4', source: 'p4', target: 'p7', type: 'step', data: { relation: 'mother' } },

  // parent couples (spouses)
  {
    id: 'e5',
    source: 'p5',
    target: 'p6',
    type: 'step',
    data: { relation: 'spouse' },
    markerEnd: MarkerType.ArrowClosed,
  },
  {
    id: 'e6',
    source: 'p7',
    target: 'p8',
    type: 'step',
    data: { relation: 'spouse' },
    markerEnd: MarkerType.ArrowClosed,
  },

  // parents -> children
  { id: 'e7', source: 'p5', target: 'p10', type: 'step', data: { relation: 'father' } },
  { id: 'e8', source: 'p6', target: 'p10', type: 'step', data: { relation: 'mother' } },

  { id: 'e9', source: 'p5', target: 'p11', type: 'step', data: { relation: 'father' } },
  { id: 'e10', source: 'p6', target: 'p11', type: 'step', data: { relation: 'mother' } },

  { id: 'e11', source: 'p7', target: 'p12', type: 'step', data: { relation: 'father' } },
  { id: 'e12', source: 'p8', target: 'p12', type: 'step', data: { relation: 'mother' } },

  { id: 'e13', source: 'p7', target: 'p13', type: 'step', data: { relation: 'father' } },
  { id: 'e14', source: 'p8', target: 'p13', type: 'step', data: { relation: 'mother' } },

  { id: 'e15', source: 'p9', target: 'p14', type: 'step', data: { relation: 'aunt' } },

  // child with multiple partners (p5 has two partners p15/p31)
  { id: 'e16', source: 'p5', target: 'p15', type: 'step', data: { relation: 'spouse' } },
  { id: 'e17', source: 'p5', target: 'p31', type: 'step', data: { relation: 'spouse' } },

  // children -> grandchildren (two families)
  { id: 'e18', source: 'p10', target: 'p17', type: 'step', data: { relation: 'parent' } },
  { id: 'e19', source: 'p15', target: 'p17', type: 'step', data: { relation: 'parent' } },

  { id: 'e20', source: 'p10', target: 'p18', type: 'step', data: { relation: 'parent' } },
  { id: 'e21', source: 'p15', target: 'p18', type: 'step', data: { relation: 'parent' } },

  { id: 'e22', source: 'p11', target: 'p19', type: 'step', data: { relation: 'parent' } },
  { id: 'e23', source: 'p31', target: 'p19', type: 'step', data: { relation: 'parent' } },

  { id: 'e24', source: 'p12', target: 'p20', type: 'step', data: { relation: 'parent' } },
  { id: 'e25', source: 'p32', target: 'p20', type: 'step', data: { relation: 'parent' } },

  { id: 'e26', source: 'p13', target: 'p21', type: 'step', data: { relation: 'parent' } },
  { id: 'e27', source: 'p13', target: 'p22', type: 'step', data: { relation: 'parent' } },

  { id: 'e28', source: 'p14', target: 'p23', type: 'step', data: { relation: 'parent' } },

  // spouse / partner edges for grandchildren
  { id: 'e29', source: 'p17', target: 'p24', type: 'step', data: { relation: 'spouse' } },
  { id: 'e30', source: 'p21', target: 'p25', type: 'step', data: { relation: 'spouse' } },

  // grandchildren -> great grandchildren
  { id: 'e31', source: 'p17', target: 'p28', type: 'step', data: { relation: 'parent' } },
  { id: 'e32', source: 'p24', target: 'p28', type: 'step', data: { relation: 'parent' } },

  { id: 'e33', source: 'p18', target: 'p29', type: 'step', data: { relation: 'parent' } },
  { id: 'e34', source: 'p19', target: 'p30', type: 'step', data: { relation: 'parent' } },

  // cousins & extra connections
  { id: 'e35', source: 'p9', target: 'p26', type: 'step', data: { relation: 'cousin' } },
  { id: 'e36', source: 'p26', target: 'p27', type: 'step', data: { relation: 'sibling' } },

  // multiple wives for the same parent (p11 has two wives p35 & p36)
  { id: 'e37', source: 'p11', target: 'p35', type: 'step', data: { relation: 'spouse' } },
  { id: 'e38', source: 'p11', target: 'p36', type: 'step', data: { relation: 'spouse' } },

  // children from different unions (test multi-tenant relationships)
  { id: 'e39', source: 'p11', target: 'p19', type: 'step', data: { relation: 'parent' } },
  { id: 'e40', source: 'p35', target: 'p19', type: 'step', data: { relation: 'parent' } },

  { id: 'e41', source: 'p7', target: 'p12', type: 'step', data: { relation: 'parent' } },

  // friends / non-family links
  { id: 'e42', source: 'p33', target: 'p34', type: 'step', data: { relation: 'friend' } },

  // more edges to enlarge graph density
  { id: 'e43', source: 'p6', target: 'p11', type: 'step', data: { relation: 'parent' } },
  { id: 'e44', source: 'p2', target: 'p6', type: 'step', data: { relation: 'parent' } },

  // a few labeled edges with arrow markers
  {
    id: 'e45',
    source: 'p1',
    target: 'p2',
    type: 'step',
    data: { relation: 'spouse' },
    markerEnd: MarkerType.ArrowClosed,
  },
  {
    id: 'e46',
    source: 'p3',
    target: 'p4',
    type: 'step',
    data: { relation: 'spouse' },
    markerEnd: MarkerType.ArrowClosed,
  },

  // test cross-generation spouse
  {
    id: 'e47',
    source: 'p12',
    target: 'p15',
    type: 'step',
    data: { relation: 'spouse' },
    markerEnd: MarkerType.ArrowClosed,
  },

  // duplicate relationships (same parent different partner)
  { id: 'e48', source: 'p5', target: 'p11', type: 'step', data: { relation: 'parent' } },
  { id: 'e49', source: 'p31', target: 'p19', type: 'step', data: { relation: 'parent' } },

  // final extra edges for robustness
  { id: 'e50', source: 'p22', target: 'p33', type: 'step', data: { relation: 'related' } },
  { id: 'e51', source: 'p20', target: 'p21', type: 'step', data: { relation: 'cousin' } },
  { id: 'e52', source: 'p27', target: 'p26', type: 'step', data: { relation: 'sibling' } },
  { id: 'e53', source: 'p19', target: 'p29', type: 'step', data: { relation: 'parent' } },
  { id: 'e54', source: 'p24', target: 'p17', type: 'step', data: { relation: 'spouse' } },
  { id: 'e55', source: 'p35', target: 'p36', type: 'step', data: { relation: 'sibling' } },
  { id: 'e56', source: 'p36', target: 'p23', type: 'step', data: { relation: 'parent' } },
  { id: 'e57', source: 'p25', target: 'p23', type: 'step', data: { relation: 'parent' } },
  { id: 'e58', source: 'p14', target: 'p21', type: 'step', data: { relation: 'parent' } },
  { id: 'e59', source: 'p21', target: 'p30', type: 'step', data: { relation: 'parent' } },
  { id: 'e60', source: 'p28', target: 'p29', type: 'step', data: { relation: 'sibling' } },
]
