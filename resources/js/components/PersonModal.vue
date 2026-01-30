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

const open = defineModel<boolean>('open')
interface LoginForm {
  relation: string
  name: string
  birth: Date
  avatar: string
  type: string
  gender: number
}

const { errors, setErrors, setFieldValue, values, handleSubmit } = useForm<LoginForm>({
  initialValues: {
    relation: '',
    name: '',
    birth: new Date(),
    avatar: '',
    type: 'person',
    gender: 1
  },
})

const name = useField<string>('name')
const birth = useField<Date>('birth')
const gender = useField<Date>('gender')


const familyStore = useFamilyStore()

const onSubmit = handleSubmit(async (values) => {
  console.log('values', values);
  
})
// function doConfirm() {
//   addNodeAndRelation(person.value.relationType)
// }

function addNodeAndRelation(relation: string) {
  switch (relation) {
    case 'child':
      familyStore.addChild(person.value)
      break
    case 'mother':
      return 'child'
    case 'spouse':
      familyStore.addSpouse(person.value)
      break
    case 'sibling':
      return 'sibling'
    default:
      return 'parent'
  }
}

function doCancel() {
  emit('cancel')
}
</script>

<template>
  <Sheet :open="open" @update:open="open = $event">
    <!-- <SheetTrigger>Open</SheetTrigger> -->
    <SheetContent>
      <SheetHeader>
        <SheetTitle>Add relation !</SheetTitle>
      </SheetHeader>
      <div class="grid w-full max-w-sm gap-6 p-3">
        <Input label="Name" tooltip="We'll use this to send you notifications" placeholder="shadcn@vercel.com" v-model="name.value.value"/>
        <DatePicker class="w-full" v-model="birth.value.value"/>
        <Select class="w-full" v-model="gender.value.value"/>
        <InputGroup>
          <InputGroupInput placeholder="Enter your username" />
          <InputGroupAddon align="inline-end">
            <InputGroupText>@company.com</InputGroupText>
          </InputGroupAddon>
        </InputGroup>
        <InputGroup>
          <InputGroupTextarea placeholder="Enter your message" />
          <InputGroupAddon align="block-end">
            <InputGroupText class="text-xs text-muted-foreground">
              120 characters left
            </InputGroupText>
          </InputGroupAddon>
        </InputGroup>
      </div>
      <SheetFooter>
        <div class="flex gap-2 w-full">
          <Button class="w-1/2" @click="onSubmit">Submit</Button>
          <Button class="w-1/2" variant="outline" @click="() => open = false">Cancel</Button>
        </div>
      </SheetFooter>
    </SheetContent>
  </Sheet>
</template>
