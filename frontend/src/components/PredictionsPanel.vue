<script setup lang="ts">
import type { ChampionshipPrediction } from '@/types/types'

defineProps<{
  predictions: ChampionshipPrediction[]
}>()
</script>

<template>
  <table>
    <thead>
      <tr>
        <th>Team</th>
        <th>Championship %</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="item in predictions" :key="item.team.id">
        <td>{{ item.team.name }}</td>
        <td>{{ item.percentage }}%</td>
      </tr>
    </tbody>
  </table>
</template>