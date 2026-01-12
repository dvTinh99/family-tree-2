<script setup lang="ts">
import { defineProps } from 'vue'
import type { Person } from '@/types/family'

interface Props {
  data: {
    person: Person
  }
}

defineProps<Props>()
</script>

<template>
  <div
    class="rounded-xl border bg-white shadow-md p-3 text-center min-w-[160px]"
    :class="data.person.gender === 'male' ? 'border-blue-400' : 'border-pink-400'"
  >
    <div class="font-semibold text-base">
      {{ data.person.name }}
    </div>
    <div class="text-xs text-gray-500">
      {{ data.person.birth }}
      <span v-if="data.person.death"> - {{ data.person.death }}</span>
    </div>
  </div>
</template>
