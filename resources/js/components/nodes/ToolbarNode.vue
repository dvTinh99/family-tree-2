<script setup lang="ts">
import { Handle, Position, useVueFlow } from '@vue-flow/core'
import { NodeToolbar } from '@vue-flow/node-toolbar'
import personIcon from '@/assets/svgs/person.svg'
import addPersonIcon from '@/assets/svgs/add-person.svg'
import { computed } from 'vue'


const props = defineProps(['id', 'data', 'node'])

const actions = [{
    click: () => emitAddRelation('father'),
    icon: addPersonIcon
}]
const emit = defineEmits(['add-relation', 'toggle-branch'])
const { updateNodeData } = useVueFlow()

function emitAddRelation(type: string) {

    console.log('emitAddRelation');
    
  emit('add-relation', { sourceId: props.id, relationType: type })
}

function handleButtonAction(action, click: any) {
    console.log(typeof click);
    
    updateNodeData(props.id, { action })
    click()
}

const name = computed(() => props?.data.name || props.data.label || props.node.label || 'Unknown')
</script>

<template>
    <Handle type="target" :position="Position.Top" id="top-target" />
    <Handle type="source" :position="Position.Top" id="top-source" />

    <Handle type="target" :position="Position.Bottom" id="bottom-target" />
    <Handle type="source" :position="Position.Bottom" id="bottom-source" />

    <Handle type="target" :position="Position.Left" id="left-target" />
    <Handle type="source" :position="Position.Left" id="left-source" />

    <Handle type="target" :position="Position.Right" id="right-target" />
    <Handle type="source" :position="Position.Right" id="right-source" />
  <NodeToolbar :is-visible="data?.toolbarVisible" :position="data?.toolbarPosition || Position.Top">
    <button
      v-for="(action, index) of actions"
      :key="index"
      type="button"
      :class="{ selected: action === data.action }"
      @click="handleButtonAction(action, action?.click)"
    >
      <component :is="action.icon" class="w-[15px] h-[20px] text-white "/>
    </button>
  </NodeToolbar>

  <div :class="['person-node', { selected }]"
      class="relative w-[180px] h-[90px] flex items-center gap-2 p-2 bg-white border border-gray-200 rounded-lg shadow-sm">
    <img
        v-if="props.node.avatar"
        :src="props.node.avatar"
        alt="avatar"
        style="width: 56px; height: 56px; border-radius: 999px; object-fit: cover"
      />
      <div v-else>
        <personIcon style="width: 56px; height: 56px; border-radius: 999px; object-fit: cover" />
      </div>
      <div>
        {{ name }}
      </div>
  </div>
</template>
<style>
 .vue-flow__node-toolbar {
  display: flex;
  gap: 0.5rem;
  align-items: center;
  background-color: #2d3748;
  padding: 8px;
  border-radius: 8px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
}

.vue-flow__node-toolbar button {
  background: #4a5568;
  color: white;
  border: none;
  padding: 0.5rem 1rem;
  border-radius: 8px;
  cursor: pointer;
}

.vue-flow__node-toolbar button.selected {
  background: #2563eb;
}

.vue-flow__node-toolbar button:hover {
  background: #2563eb;
}

.vue-flow__node-menu {
  /* padding: 16px 24px; */
  border-radius: 8px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
}

.vue-flow__node-menu.selected {
  box-shadow: 0 0 0 2px #2563eb;
}

</style>