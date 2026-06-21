<script setup lang="ts">
import type { Standing } from '@/types/types'

defineProps<{
  standings: Standing[]
}>()
</script>

<template>
  <table>
    <thead>
      <tr>
        <th>Team</th>
        <th>P</th>
        <th>W</th>
        <th>D</th>
        <th>L</th>
        <th>GD</th>
        <th>Pts</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="row in standings" :key="row.team.id">
        <td>{{ row.team.name }}</td>
        <td>{{ row.played }}</td>
        <td>{{ row.won }}</td>
        <td>{{ row.drawn }}</td>
        <td>{{ row.lost }}</td>
        <td>{{ row.goal_difference }}</td>
        <td>{{ row.points }}</td>
      </tr>
    </tbody>
  </table>
</template>