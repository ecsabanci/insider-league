<script setup lang="ts">
import type { AllWeekFixtures } from '@/types/types'

defineProps<{
  fixtures: AllWeekFixtures
}>()
</script>

<template>
  <div class="fixtures-grid">
    <div v-for="(week, index) in fixtures" :key="index" class="week-card">
      <div class="week-header">Week {{ index + 1 }}</div>
      <div class="match" v-for="(match, matchIndex) in week" :key="matchIndex">
        <span>{{ match.home }}</span>
        <span class="score">
          <template v-if="match.played">{{ match.home_goals }} - {{ match.away_goals }}</template>
          <template v-else>vs</template>
        </span>
        <span>{{ match.away }}</span>
      </div>
    </div>
  </div>
</template>

<style scoped>
.fixtures-grid {
  display: flex;
  flex-wrap: wrap;
  gap: 16px;
}

.week-card {
  border: 2px solid var(--color-border);
  background: var(--color-surface);
  width: 280px;
}

.week-header {
  background: var(--color-surface-alt);
  border-bottom: 2px solid var(--accent);
  padding: 10px 14px;
  font-weight: 700;
  text-transform: uppercase;
  font-size: 13px;
  color: var(--accent);
}

.match {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 12px 14px;
  border-bottom: 1px solid var(--color-border);
  font-size: 13px;
}

.match:last-child {
  border-bottom: none;
}

.score {
  font-weight: 700;
  color: var(--accent-cyan);
}
</style>