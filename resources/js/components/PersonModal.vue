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
import { Label } from '@/components/ui/label'
import { Tooltip, TooltipContent, TooltipProvider, TooltipTrigger } from '@/components/ui/tooltip'

import { useForm } from 'vee-validate'

const open = defineModel<boolean>('open')
interface LoginForm {
  relation: string
  name: string
  birth: string
  avatar: string
  type: string
}

const { errors, setErrors, setFieldValue, values } = useForm<LoginForm>({
  initialValues: {
    relation: '',
    name: '',
    birth: '',
    avatar: '',
    type: 'person',
  },
})

const familyStore = useFamilyStore()

function doConfirm() {
  addNodeAndRelation(person.value.relationType)
}

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
        <SheetTitle>Add relation?</SheetTitle>
      </SheetHeader>
      <div class="grid w-full max-w-sm gap-6 p-3">
        <InputGroup>
          <InputGroupInput id="email-2" placeholder="shadcn@vercel.com" />
          <InputGroupAddon align="block-start">
            <Label for="email-2" class="text-foreground"> Email </Label>
            <TooltipProvider>
              <Tooltip>
                <TooltipTrigger as-child>
                  <InputGroupButton
                    variant="ghost"
                    aria-label="Help"
                    class="ml-auto rounded-full"
                    size="icon-xs"
                  >
                    <InfoIcon />
                  </InputGroupButton>
                </TooltipTrigger>
                <TooltipContent>
                  <p>We'll use this to send you notifications</p>
                </TooltipContent>
              </Tooltip>
            </TooltipProvider>
          </InputGroupAddon>
        </InputGroup>
        <InputGroup>
          <InputGroupAddon>
            <InputGroupText>$</InputGroupText>
          </InputGroupAddon>
          <InputGroupInput placeholder="0.00" />
          <InputGroupAddon align="inline-end">
            <InputGroupText>USD</InputGroupText>
          </InputGroupAddon>
        </InputGroup>
        <InputGroup>
          <InputGroupAddon>
            <InputGroupText>https://</InputGroupText>
          </InputGroupAddon>
          <InputGroupInput placeholder="example.com" class="!pl-0.5" />
          <InputGroupAddon align="inline-end">
            <InputGroupText>.com</InputGroupText>
          </InputGroupAddon>
        </InputGroup>
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
    </SheetContent>
  </Sheet>
</template>
