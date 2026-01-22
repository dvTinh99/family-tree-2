<script setup lang="ts">
import { h, onMounted, ref, nextTick, reactive } from 'vue'
import { Background } from '@vue-flow/background'
import { Edge, MarkerType, Node, Panel, useVueFlow, VueFlow } from '@vue-flow/core'
import PersonNode from '@/components/nodes/PersonNode.vue'
import { familyTreeLayout, addSpouseAndRerouteParents } from '@/utils/familyTreeLayout'
import SpouseNode from '@/components/nodes/SpouseNode.vue'
import PersonModal from '@/components/PersonModal.vue'
import { useFamilyTreeStore } from '@/store/familyTree'
import {
  Dialog,
  DialogContent,
  DialogHeader,
  DialogTitle,
  DialogDescription,
  DialogFooter,
  DialogTrigger,
  DialogClose,
} from '@/components/ui/dialog'
import { Button } from '@/components/ui/button'
const isLoading = ref(false)
const nodes = ref<any[]>([
  {
    id: '1',
    type: 'person',
    label: 'Parent A',
    data: { name: 'Parent A' },
  },
  {
    id: '2',
    type: 'person',
    label: 'Parent B',
    data: { name: 'Parent B' },
  },
  {
    id: '3',
    type: 'person',
    data: {},
  },
  {
    id: '4',
    type: 'person',
    data: {},
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
    source: '1',
    target: '4',
    type: 'step',
    data: { relation: 'parent' },
    sourceHandle: 'bottom-source',
    targetHandle: 'top-target',
  },
])

const familyStore = useFamilyTreeStore()

const { fitView } = useVueFlow()
async function layoutGraph(direction) {
  const { nodes: nodesFormat, edges: edgesFormat } = addSpouseAndRerouteParents(
    nodes.value,
    edges.value
  )

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

// onMounted(() => nextTick(() => layoutGraph('TB')))
</script>

<template>
  <div class="h-screen w-screen" v-if="!isLoading">
  <Dialog>
    <!-- Nút mở dialog -->
    <DialogTrigger as-child>
      <Button variant="outline">Open Dialog</Button>
    </DialogTrigger>

    <!-- Nội dung dialog -->
    <DialogContent class="sm:max-w-[425px]">
      <DialogHeader>
        <DialogTitle>Edit Profile</DialogTitle>
        <DialogDescription>
          Make changes here and save when done.
        </DialogDescription>
      </DialogHeader>

      <!-- Actions / Footer -->
      <DialogFooter>
        <DialogClose asChild>
          <Button variant="secondary">Cancel</Button>
        </DialogClose>
        <DialogClose>
          <Button>Save changes</Button>
        </DialogClose>
      </DialogFooter>
    </DialogContent>
  </Dialog>
    <div v-if="showPersonModal">
      <PersonModal v-model="relationForm" @cancel="() => (showPersonModal = false)" />
    </div>
    <VueFlow v-model:nodes="familyStore.nodes" :edges="familyStore.edges" @node-click="onNodeClick">
      <template #node-person>
        <PersonNode @add-relation="onAddRelationIntent" />
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
