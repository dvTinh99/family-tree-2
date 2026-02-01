<script setup lang="ts">
import { h, onMounted, ref, nextTick, reactive, computed, onBeforeMount, watch, watchEffect } from 'vue'
import { Background } from '@vue-flow/background'
import { MarkerType, Panel, Position, useVueFlow, VueFlow } from '@vue-flow/core'
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
import '@vue-flow/controls/dist/style.css'
import ToolbarNode from '@/components/nodes/ToolbarNode.vue'

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
const localNodes = ref([
  // {
  //   id: '1',
  //   type: 'menu',
  //   data: { label: 'toolbar top', toolbarPosition: Position.Top },
  //   position: { x: 200, y: 0 },
  // },
])
const familyStore = useFamilyStore()
const authStore = useAuthStore()

const nodeStore = computed(() => familyStore.nodesOrigin)

const { fitView, nodesDraggable, setViewport, setNodesSelection } = useVueFlow()
async function layoutGraph(direction: string = 'TB') {
  familyStore.$reset()

  nextTick(() => {
    fitView()
  })
  isLoading.value = false
}

const selectedPerson = ref(null)
function handleCloseModal() {
  showPersonModal.value = false
  selectedPerson.value = null
}

function onAddRelationIntent({ sourceId, relationType }) {
  console.log('emit ra home');
  
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
function resetTransform(zoom = 1) {
  const viewHeight = window.innerHeight
  const viewWidth = window.innerWidth

  setViewport({ x: (viewWidth/2.5), y: (viewHeight/2), zoom })
}

onBeforeMount(async () => {
  await familyStore.initStore()
})

onMounted(async () => {
  nextTick(() => {
    // layoutGraph('TB')
    // localNodes.value = familyStore.nodes as any
    resetTransform(1)
  })
})

// watch(nodeStore.value, (newVal, oldVal) => {
//   console.log('newVal', newVal);
//   console.log('oldVal', oldVal);
  
//   localNodes.value = newVal as any
// })
const updateNodeLocal = () => {
  // console.log('nodeStore', nodeStore.value);
  localNodes.value = familyStore.nodes as any
  
}
watchEffect(updateNodeLocal)
</script>

<template>
  <div class="h-screen w-screen" v-if="!isLoading">
    <PersonModal v-model:open="showPersonModal" />
    <VueFlow
      v-model:nodes="familyStore.nodes"
      v-model:edges="familyStore.edges"
      :default-edge-options="{ type: 'animation', animated: true }"
      :default-node-options="{ type: 'person' }"
      @node-click="onNodeClick"
      class="basic-flow"
      :default-viewport="{ zoom: 0.5 }"
      :min-zoom="0.2"
      :max-zoom="4"
    >
      <template #node-person="props">
        <PersonNode :id="props.id" :data="props.data" :node="props" @add-relation="onAddRelationIntent" />
      </template>
      <template #node-menu="props">
        <ToolbarNode :id="props.id" :data="props.data" :node="props" @add-relation="onAddRelationIntent"/>
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
        <!-- <ControlButton title="Reset Transform" @click="resetTransform">
          <Icon name="reset" />
        </ControlButton> -->

        <!-- <ControlButton title="Shuffle Node Positions" @click="updatePos">
          <Icon name="update" />
        </ControlButton> -->
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
