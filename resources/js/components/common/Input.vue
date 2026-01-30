<script setup lang="ts">
import {
  InputGroup,
  InputGroupAddon,
  InputGroupButton,
  InputGroupInput,
  InputGroupText,
  InputGroupTextarea,
} from '@/components/ui/input-group'
import { InfoIcon } from 'lucide-vue-next'
import { Label } from '@/components/ui/label'
import { Tooltip, TooltipContent, TooltipProvider, TooltipTrigger } from '@/components/ui/tooltip'

const value = defineModel()
defineProps<{
    label? : string
    placeholder?: string
    tooltip?: string
}>()
</script>
<template>
    <div>
        <InputGroup>
          <InputGroupInput id="email-2" :placeholder="placeholder" v-model="value"/>
          <InputGroupAddon align="block-start">
            <Label for="email-2" class="text-foreground"> {{ label }} </Label>
            <TooltipProvider v-if="tooltip">
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
                  <p>{{ tooltip }}</p>
                </TooltipContent>
              </Tooltip>
            </TooltipProvider>
          </InputGroupAddon>
        </InputGroup>
    </div>
</template>