<script setup lang="ts">
import type { PlayedWeek } from '@/types/types'

defineProps<{
  weeks: PlayedWeek[]
}>()
</script>

<template>
  <div class="week-results">
    <div v-if="weeks.length === 0" class="empty">Henüz maç oynanmadı</div>

    <div v-for="item in weeks" :key="item.week" class="week-block">
      <div class="week-title">Week {{ item.week }}</div>
      <div v-for="(match, index) in item.matches" :key="index" class="match">
        <span class="team-name">{{ match.home }}</span>
        <span class="score">{{ match.home_goals }} - {{ match.away_goals }}</span>
        <span class="team-name">{{ match.away }}</span>
      </div>
    </div>
  </div>
</template>

<style scoped>
.week-results {
  border: 2px solid var(--color-border);
  background: var(--color-surface);
  height: 200px;
  overflow-y: auto;
}

.week-block {
  border-bottom: 2px solid var(--color-border);
}

.week-block:last-child {
  border-bottom: none;
}

.week-title {
  background: var(--color-surface-alt);
  color: var(--accent);
  font-weight: 700;
  text-transform: uppercase;
  font-size: 12px;
  padding: 8px 14px;
}

.match {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 10px 14px;
  border-bottom: 1px solid var(--color-border);
  font-size: 13px;
}

.match:last-child {
  border-bottom: none;
}

.team-name {
  width: 40%;
  text-align: center;
}

.score {
  font-weight: 700;
  color: var(--accent-cyan);
}

.empty {
  padding: 16px;
  color: var(--color-muted);
  text-align: center;
  font-size: 13px;
}
</style>