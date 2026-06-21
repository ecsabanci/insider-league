<script setup lang="ts">
import type { Standing } from '@/types/types'

defineProps<{
  standings: Standing[]
}>()
</script>

<template>
  <table class="standings">
    <thead>
      <tr>
        <th class="team-col">Team</th>
        <th>P</th>
        <th>W</th>
        <th>D</th>
        <th>L</th>
        <th>GD</th>
        <th>Pts</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="(row, index) in standings" :key="row.team.id" :class="{ leader: index === 0 }">
        <td class="team-col">
          <span class="rank">{{ index + 1 }}</span>
          {{ row.team.name }}
        </td>
        <td>{{ row.played }}</td>
        <td>{{ row.won }}</td>
        <td>{{ row.drawn }}</td>
        <td>{{ row.lost }}</td>
        <td>{{ row.goal_difference }}</td>
        <td class="points">{{ row.points }}</td>
      </tr>
    </tbody>
  </table>
</template>

<style scoped>
.standings {
  width: 100%;
  border-collapse: collapse;
  border: 2px solid var(--color-border);
  background: var(--color-surface);
}

.standings th {
  background: var(--color-surface-alt);
  color: var(--color-muted);
  text-transform: uppercase;
  font-size: 11px;
  padding: 12px 10px;
  text-align: center;
  border-bottom: 2px solid var(--accent);
}

.standings th.team-col,
.standings td.team-col {
  text-align: left;
}

.standings td {
  padding: 12px 10px;
  text-align: center;
  border-bottom: 1px solid var(--color-border);
  font-size: 14px;
}

.standings td.team-col {
  font-weight: 700;
}

.rank {
  color: var(--accent);
  font-weight: 700;
  margin-right: 8px;
}

.points {
  font-weight: 700;
  color: var(--accent-cyan);
}

.leader .points {
  color: var(--accent);
}
</style>