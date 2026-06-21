<script setup lang="ts">
import type { AllWeekFixtures } from '@/types/types'

defineProps<{
  fixtures: AllWeekFixtures
}>()
</script>

<template>
  <div>
    <div v-for="(week, index) in fixtures" :key="index">
      <h3>Week {{ index + 1 }}</h3>
      <ul>
        <li v-for="(match, matchIndex) in week" :key="matchIndex">
          {{ match.home }}
          <span v-if="match.played">{{ match.home_goals }} - {{ match.away_goals }}</span>
          <span v-else>-</span>
          {{ match.away }}
        </li>
      </ul>
    </div>
  </div>
</template>