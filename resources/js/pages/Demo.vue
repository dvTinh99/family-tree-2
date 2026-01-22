<script setup lang="ts">
import { h, onMounted, ref, nextTick, reactive } from 'vue'
import { Background } from '@vue-flow/background'
import { Edge, MarkerType, Node, Panel, useVueFlow, VueFlow } from '@vue-flow/core'
import PersonNode from '@/components/nodes/PersonNode.vue'
import { familyTreeLayout, addSpouseAndRerouteParents } from '@/utils/familyTreeLayout'
import SpouseNode from '@/components/nodes/SpouseNode.vue'
import PersonModal from '@/components/PersonModal.vue'
import { useFamilyTreeStore } from '@/store/familyTree'

const isLoading = ref(false)
const nodes = ref<any[]>([
  {
    id: '1',
    type: 'person',
    label: 'GrandFather',
    data: { name: 'GrandFather', avatar: 'http://app.family.test/images/grandfather.svg' },
  },
  {
    id: '2',
    type: 'person',
    label: 'GrandMother',
    data: { name: 'GrandMother', avatar: 'http://app.family.test/images/grandmother.svg' },
  },
  {
    id: '1.1',
    type: 'person',
    label: 'GrandFather',
    data: { name: 'GrandFather', avatar: 'http://app.family.test/images/ong_ngoai.svg' },
  },
  {
    id: '2.1',
    type: 'person',
    label: 'GrandMother',
    data: { name: 'GrandMother', avatar: 'http://app.family.test/images/ba_ngoai.svg' },
  },
  {
    id: '3',
    type: 'person',
    label: 'Father',
    data: { name: 'Father', avatar: 'http://app.family.test/images/father.svg' },
  },
  {
    id: '4',
    type: 'person',
    label: 'Mother',
    data: { name: 'Mother', avatar: 'http://app.family.test/images/mother.svg' },
  },
  {
    id: '5',
    type: 'person',
    label: 'Me',
    data: { name: 'Me', avatar: 'http://app.family.test/images/me.jpeg' },
  },
  {
    id: '6',
    type: 'person',
    label: 'Sister',
    data: { name: 'Sister', avatar: 'http://app.family.test/images/sister.svg' },
  },
])
const edges = ref<Edge[]>([
  {
    id: 'e1',
    source: '1',
    target: '2',
    type: 'step',
    data: { relation: 'spouse' },
    sourceHandle: 'right-source',
    targetHandle: 'left-target',
  },
  {
    id: 'e11',
    source: '1.1',
    target: '2.1',
    type: 'step',
    data: { relation: 'spouse' },
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
    source: '1.1',
    target: '4',
    type: 'step',
    data: { relation: 'parent' },
    sourceHandle: 'bottom-source',
    targetHandle: 'top-target',
  },
  {
    id: 'e4',
    source: '3',
    target: '4',
    type: 'step',
    data: { relation: 'spouse' },
    sourceHandle: 'right-source',
    targetHandle: 'left-target',
  },
  {
    id: 'e5',
    source: '3',
    target: '5',
    type: 'step',
    data: { relation: 'parent' },
    sourceHandle: 'bottom-source',
    targetHandle: 'top-target',
  },
  {
    id: 'e6',
    source: '3',
    target: '6',
    type: 'step',
    data: { relation: 'parent' },
    sourceHandle: 'bottom-source',
    targetHandle: 'top-target',
  },
])

const familyStore = useFamilyTreeStore()

const { fitView } = useVueFlow()
async function layoutGraph(direction: string = 'TB') {
  const { nodes: nodesFormat, edges: edgesFormat } = addSpouseAndRerouteParents(
    nodes.value,
    edges.value
  )

  console.log('nodesFormat', nodesFormat);
  console.log('edgesFormat', edgesFormat);

  nodes.value = familyTreeLayout(nodesFormat, edgesFormat)
  // nodes.value = nodeGraph
  edges.value = edgesFormat
  nextTick(() => {
    fitView()
  })
  isLoading.value = false
}
const relationForm = reactive({
  sourceId: '',
  relationType: '',
  name: '',
  birth: '',
  avatar: '',
})
const selectedPerson = ref(null)
function handleCloseModal() {
  showPersonModal.value = false
  selectedPerson.value = null
}

function onAddRelationIntent({ sourceId, relationType }) {
  relationForm.sourceId = sourceId
  relationForm.relationType = relationType
  relationForm.name = '' // optional default
  relationForm.birth = ''
  relationForm.avatar = `https://i.pravatar.cc/80?u=${Date.now()}`
  showPersonModal.value = true
}

const showPersonModal = ref(false)

function onNodeClick({ event, node }) {
  console.log('node clicked', node, event)

  familyStore.setNodeSelected(node)
}

onMounted(() => nextTick(() => layoutGraph('TB')))
</script>

<template>
  <div class="h-screen w-screen" v-if="!isLoading">
    <div v-if="showPersonModal">
      <PersonModal v-model="relationForm" @cancel="() => (showPersonModal = false)" />
    </div>
    <VueFlow :nodes="nodes" :edges="edges" @node-click="onNodeClick">
      <template #node-person="personNodeProps">
        <PersonNode v-bind="personNodeProps" @add-relation="onAddRelationIntent" />
      </template>
      <template #node-spouse>
        <SpouseNode />
      </template>
      <Background />

      <Panel class="process-panel" position="top-right">
        <div class="layout-panel">
          <button title="set horizontal layout" @click="layoutGraph('LR')">Horizon</button>

          <button title="set vertical layout" @click="layoutGraph('TB')">vertical</button>
        </div>
      </Panel>
    </VueFlow>
  </div>
</template>
