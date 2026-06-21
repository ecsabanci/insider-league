<script setup lang="ts">
import type { ChampionshipPrediction } from '@/types/types'

defineProps<{
  predictions: ChampionshipPrediction[]
}>()
</script>

<template>
  <table class="predictions">
    <thead>
      <tr>
        <th class="team-col">Team</th>
        <th>Championship</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="item in predictions" :key="item.team.id">
        <td class="team-col">{{ item.team.name }}</td>
        <td>
          <div class="bar-row">
            <div class="bar-track">
              <div class="bar-fill" :style="{ width: item.percentage + '%' }"></div>
            </div>
            <span class="pct">{{ item.percentage }}%</span>
          </div>
        </td>
      </tr>
    </tbody>
  </table>
</template>

<style scoped>
.predictions {
  width: 100%;
  border-collapse: collapse;
  border: 2px solid var(--color-border);
  background: var(--color-surface);
}

.predictions th {
  background: var(--color-surface-alt);
  color: var(--color-muted);
  text-transform: uppercase;
  font-size: 11px;
  padding: 12px 10px;
  text-align: left;
  border-bottom: 2px solid var(--accent-magenta);
}

.predictions td {
  padding: 12px 10px;
  border-bottom: 1px solid var(--color-border);
  font-size: 14px;
}

.predictions td.team-col {
  font-weight: 700;
}

.bar-row {
  display: flex;
  align-items: center;
  gap: 10px;
}

.bar-track {
  flex: 1;
  height: 18px;
  background: var(--color-surface-alt);
  min-width: 120px;
}

.bar-fill {
  height: 100%;
  background: var(--accent-magenta);
  transition: width 0.3s;
}

.pct {
  font-weight: 700;
  min-width: 48px;
  text-align: right;
}
</style>