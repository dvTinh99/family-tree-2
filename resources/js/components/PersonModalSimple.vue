<script setup lang="ts">
import { ref, watch } from 'vue'

import { Sheet, SheetContent, SheetFooter, SheetHeader, SheetTitle } from '@/components/ui/sheet'

import Input from './common/Input.vue'
import Button from './ui/button/Button.vue'
import DatePicker from './common/DatePicker.vue'
import Select from './common/Select.vue'
import TextArea from './common/TextArea.vue'

const open = defineModel<boolean>('open')
const emit = defineEmits(['cancel', 'added'])

const props = defineProps<{
  relationType?: string
}>()

const name = ref('')
const birth = ref(new Date())
const gender = ref(1)
const avatar = ref('')
const avatarFile = ref<File | null>(null)
const avatarPreview = ref('')
const biography = ref('')

watch(open, (val) => {
  if (val) {
    resetForm()
  }
})

function resetForm() {
  name.value = ''
  birth.value = new Date()
  gender.value = 1
  avatar.value = ''
  avatarFile.value = null
  avatarPreview.value = ''
  biography.value = ''
}

function onFileChange(e: Event) {
  const file = (e.target as HTMLInputElement).files?.[0] || null
  if (file) {
    avatarFile.value = file
    const reader = new FileReader()
    reader.onload = () => {
      avatarPreview.value = reader.result as string
      avatar.value = avatarPreview.value
    }
    reader.readAsDataURL(file)
  } else {
    avatarFile.value = null
    avatarPreview.value = ''
    avatar.value = ''
  }
}

function onSubmit() {
  if (!name.value.trim()) {
    return
  }

  emit('added', {
    name: name.value,
    birth: birth.value,
    gender: gender.value,
    avatar: avatar.value,
    biography: biography.value,
    relationType: props.relationType || 'child',
  })

  open.value = false
}

function doCancel() {
  open.value = false
  emit('cancel')
}
</script>

<template>
  <Sheet :open="open" @update:open="open = $event">
    <SheetContent>
      <SheetHeader>
        <SheetTitle>Add {{ relationType || 'person' }}</SheetTitle>
      </SheetHeader>
      <div class="grid w-full max-w-sm gap-6 p-3 overflow-scroll">
        <Input label="Name" placeholder="Full name" v-model="name" />
        <DatePicker class="w-full" v-model="birth" />
        <Select
          class="w-full"
          v-model="gender"
          :options="[
            { name: 'Male', value: 1 },
            { name: 'Female', value: 2 },
          ]"
        />
        <div>
          <label class="block text-sm font-medium mb-1">Avatar</label>
          <div class="flex items-center gap-3">
            <div
              class="w-16 h-16 bg-muted rounded overflow-hidden flex items-center justify-center"
            >
              <img
                v-if="avatarPreview || avatar"
                :src="avatarPreview || avatar"
                alt="avatar"
                class="w-full h-full object-cover"
              />
              <div v-else class="text-xs text-muted-foreground">No image</div>
            </div>
            <div>
              <input type="file" accept="image/*" @change="onFileChange" />
            </div>
          </div>
        </div>
        <TextArea label="Biography" placeholder="Input biography" v-model="biography" />
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
