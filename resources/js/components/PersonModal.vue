<script setup lang="ts">
import { useFamilyStore } from '@/store/family'
import { ref, watch, toRefs } from 'vue'
import { InfoIcon } from 'lucide-vue-next'

import {
  Sheet,
  SheetClose,
  SheetContent,
  SheetDescription,
  SheetFooter,
  SheetHeader,
  SheetTitle,
  SheetTrigger,
} from '@/components/ui/sheet'
import {
  InputGroup,
  InputGroupAddon,
  InputGroupButton,
  InputGroupInput,
  InputGroupText,
  InputGroupTextarea,
} from '@/components/ui/input-group'

import { useField, useForm } from 'vee-validate'
import Input from './common/Input.vue'
import Button from './ui/button/Button.vue'
import DatePicker from './common/DatePicker.vue'
import Select from './common/Select.vue'
import Label from './ui/label/Label.vue'
import TextArea from './common/TextArea.vue'
import { useVueFlow } from '@vue-flow/core'
import { familyTreeLayout, addSpouseAndRerouteParents, applyRelationHandles } from '@/utils/familyTreeLayout'

const open = defineModel<boolean>('open')
const emit = defineEmits(['cancel', 'added', 'update:open'])

interface AddNodeForm {
  relation: number
  name: string
  birth: Date
  avatar: string
  type: string
  gender: number
  biography: string | undefined | null

}
const { fitView, nodesDraggable, setViewport, addNodes, addEdges, toObject, fromObject } = useVueFlow()
const { errors, setErrors, setFieldValue, values, handleSubmit } = useForm<AddNodeForm>({
  initialValues: {
    relation: 1,
    name: '',
    birth: new Date(),
    avatar: '',
    type: 'person',
    gender: 1,
    biography: null
  },
})

const relation = useField<number>('relation')
const name = useField<string>('name')
const birth = useField<Date>('birth')
const gender = useField<number>('gender')
const avatar = useField<string>('avatar')
const avatarFile = ref<File | null>(null)
const avatarPreview = ref<string>('')
const biography = useField<string>('biography')

function onFileChange(e: Event) {
  const file = (e.target as HTMLInputElement).files?.[0] || null
  if (file) {
    avatarFile.value = file
    const reader = new FileReader()
    reader.onload = () => {
      avatarPreview.value = reader.result as string
      setFieldValue('avatar', avatarPreview.value)
    }
    reader.readAsDataURL(file)
  } else {
    avatarFile.value = null
    avatarPreview.value = ''
    setFieldValue('avatar', '')
  }
}

const relationOptions = [
  { name: 'Child', value: 1 },
  { name: 'Spouse', value: 2 },
]

const familyStore = useFamilyStore()

const onSubmit = handleSubmit(async (values) => {
  // generate id for new node
  const idNode = `person-${Date.now()}`

  // determine position: place below selected node if available
  const selected = familyStore.nodeSelected
  const pos = selected?.position ? { x: selected.position.x, y: (selected.position.y ?? 0) + 120 } : { x: 50, y: 150 }

  // create node object (keeps the form values as top-level props to match store usage)
  const newNode = {
    ...values,
    id: idNode,
    type: 'person',
    position: pos,
    label: values.name
  }

  // add to the vue-flow graph
  try {
    addNodes(newNode)
    // add connecting edge
    const edge = {
      id: `edge-${Date.now()}`,
      source: selected?.id || '1',
      target: idNode,
      type: 'step',
      sourceHandle: 'bottom-source',
      targetHandle: 'top-target',
      data: { relation: values.relation === 2 ? 'spouse' : 'parent' },
    }
    addEdges(edge)

    // keep store origin arrays in sync (so formatGraph / persistence works)
    if ((familyStore as any).nodesOrigin && (familyStore as any).edgesOrigin) {
      ;(familyStore as any).nodesOrigin.push(newNode)
      ;(familyStore as any).edgesOrigin.push(edge)
    }

    // recompute layout using familyTreeLayout + addSpouseAndRerouteParents
    // get current vue-flow data
    const current = toObject()
    const { nodes: nodeResult, edges: edgeResult } = addSpouseAndRerouteParents(
      current.nodes as any,
      current.edges as any
    )
    const positionedNodes = familyTreeLayout(nodeResult as any, edgeResult as any)
    const handledEdges = applyRelationHandles(edgeResult as any)

    console.log('positionedNodes', positionedNodes);
    console.log('handledEdges', handledEdges);
    

    // push new layout to vue-flow
    fromObject({ nodes: positionedNodes as any, edges: handledEdges as any })

    // try to set node selection via vue-flow store (use any to avoid typing issues)
    // try {
    //   ;(useVueFlow() as any).setNodesSelection([idNode])
    // } catch (err) {
    //   try {
    //     ;(useVueFlow() as any).setNodesSelection(idNode)
    //   } catch (e) {
    //     // ignore if not available
    //   }
    // }

    // fit the view to show the new node
    // fitView()
  } catch (err) {
    console.error('Failed to add node/edge or rerender layout', err)
  }

  // reset form
  setFieldValue('relation', 1)
  setFieldValue('name', '')
  setFieldValue('birth', new Date())
  setFieldValue('avatar', '')
  setFieldValue('gender', 1)
  setFieldValue('biography', null)
  avatarFile.value = null
  avatarPreview.value = ''

  // close and notify parent
  emit('update:open', false)
  emit('added', values)
})

function addNodeAndRelation(relation: string) {
  switch (relation) {
    case 'child':
      (familyStore as any).addChild(values as any)
      break
    case 'spouse':
      (familyStore as any).addSpouse(values as any)
      break
    default:
      (familyStore as any).addChild(values as any)
      break
  }
}

function doCancel() {
  emit('update:open', false)
  emit('cancel')
}
</script>

<template>
  <Sheet :open="open" @update:open="open = $event">
    <!-- <SheetTrigger>Open</SheetTrigger> -->
    <SheetContent>
      <SheetHeader>
        <SheetTitle>Add person</SheetTitle>
      </SheetHeader>
      <div class="grid w-full max-w-sm gap-6 p-3 overflow-scroll">
        <Input label="Name" placeholder="Full name" v-model="name.value.value" />
        <Select class="w-full" v-model="relation.value.value" :options="relationOptions" />
        <DatePicker class="w-full" v-model="birth.value.value" />
        <Select class="w-full" v-model="gender.value.value" :options="[{ name: 'Male', value: 1 }, { name: 'Female', value: 2 }]" />
        <div>
          <label class="block text-sm font-medium mb-1">Avatar</label>
          <div class="flex items-center gap-3">
            <div class="w-16 h-16 bg-muted rounded overflow-hidden flex items-center justify-center">
              <img v-if="avatarPreview || avatar.value.value" :src="avatarPreview || avatar.value.value" alt="avatar" class="w-full h-full object-cover" />
              <div v-else class="text-xs text-muted-foreground">No image</div>
            </div>
            <div>
              <input type="file" accept="image/*" @change="onFileChange" />
            </div>
          </div>
        </div>
        <TextArea label="Biography" placeholder="Input biography" v-model="biography.value.value" />
      </div>
      <SheetFooter>
        <div class="flex gap-2 w-full">
          <Button class="w-1/2" @click="onSubmit">Submit</Button>
          <Button class="w-1/2" variant="outline" @click="doCancel">Cancel</Button>
        </div>
      </SheetFooter>
    </SheetContent>
  </Sheet>
</template>
