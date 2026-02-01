<script setup lang="ts">
import {
  Select,
  SelectContent,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from '@/components/ui/select'
import Label from '@/components/ui/label/Label.vue'

import { useAttrs } from 'vue'

type TOption = {
    name: string
    value: number
}

interface Props {
    label?: string
    options?: TOption[]
    placeholder?: string
}

const props = withDefaults(defineProps<Props>(), {
  options: [
    {
      name: 'Male',
      value: 1,
    },
    {
      name: 'Female',
      value: 2,
    },
  ],
  placeholder: "Gender"
})


const value = defineModel<number>()
const attrs = useAttrs()
</script>

<template>
  <div>
    <Label v-if="label">{{ label }}</Label>
    <Select v-model="value">
      <SelectTrigger v-bind="attrs">
        <SelectValue v-if="placeholder" :placeholder="placeholder" />
      </SelectTrigger>
      <SelectContent>
        <SelectItem :value="option.value" v-for="(option, index) in options" :key="index">
          {{ option.name }}
        </SelectItem>
      </SelectContent>
    </Select>
  </div>
</template>
