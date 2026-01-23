<script setup lang="ts">
import { h, onMounted, ref, nextTick, reactive, computed, onBeforeUnmount } from 'vue'
import { Background } from '@vue-flow/background'
import { MarkerType, Panel, useVueFlow, VueFlow } from '@vue-flow/core'
import type { Edge, Node } from '@vue-flow/core'
import { ControlButton, Controls } from '@vue-flow/controls'
import PersonNode from '@/components/nodes/PersonNode.vue'
import { familyTreeLayout, addSpouseAndRerouteParents } from '@/utils/familyTreeLayout'
import SpouseNode from '@/components/nodes/SpouseNode.vue'
import PersonModal from '@/components/PersonModal.vue'
import { useFamilyStore } from '@/store/family'
import AnimationEdge from '@/components/edges/AnimationEdge.vue'
import Icon from '@/components/Icon.vue'
import SearchPanel from '@/components/SearchPanel.vue'
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar'
import { nodesInit, edgesInit } from './initial-elements'

import {
  DropdownMenu,
  DropdownMenuContent,
  DropdownMenuItem,
  DropdownMenuLabel,
  DropdownMenuSeparator,
  DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu'
import { useAuthStore } from '@/store/auth'
import { MiniMap } from '@vue-flow/minimap'

const isLoading = ref(false)

const familyStore = useFamilyStore()
const authStore = useAuthStore()

const { fitView, nodesDraggable, setViewport, setNodesSelection } = useVueFlow()
async function layoutGraph(direction: string = 'TB') {
  console.log('demo me')
  familyStore.nodesOrigin = nodesInit
  familyStore.edgesOrigin = edgesInit

  nextTick(() => {
    fitView()
  })
  isLoading.value = false
}

onBeforeUnmount(() => {
  familyStore.$reset()
})
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

function onNodeClick({ event, node }: { event: MouseEvent; node: Node }) {
  isLoading.value = true
  familyStore.setNodeSelected(node)
  isLoading.value = false
}

/**
 * To update a node or multiple nodes, you can
 * 1. Mutate the node objects *if* you're using `v-model`
 * 2. Use the `updateNode` method (from `useVueFlow`) to update the node(s)
 * 3. Create a new array of nodes and pass it to the `nodes` ref
 */
function updatePos() {
  // familyStore.nodes.value = familyStore.nodes.value.map((node) => {
  //   return {
  //     ...node,
  //     position: {
  //       x: Math.random() * 400,
  //       y: Math.random() * 400,
  //     },
  //   }
  // })
}

/**
 * Resets the current viewport transformation (zoom & pan)
 */
function resetTransform() {
  setViewport({ x: 0, y: 0, zoom: 1 })
}

onMounted(() =>
  nextTick(() => {
    layoutGraph('TB')
  })
)
</script>

<template>
  <div class="h-screen w-screen" v-if="!isLoading">
    <div v-if="showPersonModal">
      <PersonModal v-model="relationForm" @cancel="() => (showPersonModal = false)" />
    </div>
    <VueFlow
      v-model:nodes="familyStore.nodes"
      v-model:edges="familyStore.edges"
      :default-edge-options="{ type: 'animation', animated: true }"
      @node-click="onNodeClick"
      class="basic-flow"
      :default-viewport="{ zoom: 1.5 }"
      :min-zoom="0.2"
      :max-zoom="4"
    >
      <template #node-person="personNodeProps">
        <PersonNode v-bind="personNodeProps" @add-relation="onAddRelationIntent" />
      </template>
      <template #node-spouse>
        <SpouseNode />
      </template>
      <template #edge-animation="edgeProps">
        <AnimationEdge
          :id="edgeProps.id"
          :source="edgeProps.source"
          :target="edgeProps.target"
          :source-x="edgeProps.sourceX"
          :source-y="edgeProps.sourceY"
          :targetX="edgeProps.targetX"
          :targetY="edgeProps.targetY"
          :source-position="edgeProps.sourcePosition"
          :target-position="edgeProps.targetPosition"
          :data="edgeProps.data"
        />
      </template>
      <Background />

      <Controls position="top-left">
        <ControlButton title="Reset Transform" @click="resetTransform">
          <Icon name="reset" />
        </ControlButton>

        <ControlButton title="Shuffle Node Positions" @click="updatePos">
          <Icon name="update" />
        </ControlButton>
      </Controls>
      <Panel position="top-right" class="flex gap-1 items-center">
        <SearchPanel />
        <DropdownMenu>
          <DropdownMenuTrigger>
            <Avatar>
              <AvatarImage src="https://github.com/shadcn.png" alt="@shadcn" />
              <AvatarFallback>CN</AvatarFallback>
            </Avatar>
          </DropdownMenuTrigger>
          <DropdownMenuContent>
            <DropdownMenuLabel>My Account</DropdownMenuLabel>
            <DropdownMenuSeparator />
            <DropdownMenuItem>Profile</DropdownMenuItem>
            <DropdownMenuItem>Billing</DropdownMenuItem>
            <DropdownMenuItem>Team</DropdownMenuItem>
            <DropdownMenuItem @click="authStore.logout">Logout</DropdownMenuItem>
          </DropdownMenuContent>
        </DropdownMenu>
      </Panel>

      <MiniMap />
    </VueFlow>
  </div>
</template>
<style scoped>
.basic-flow .vue-flow__controls {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
}
</style>
