<script setup lang="ts">
import { onMounted } from 'vue'
import { useInsiderLeagueStore } from '@/stores/insiderLeague'

const store = useInsiderLeagueStore()

onMounted(() => {
  store.refreshAll()
})
</script>

<template>
  <main style="padding: 20px; font-family: sans-serif">
    <h1>Insider One Champions League</h1>

    <p v-if="store.loading">Loading...</p>

    <button @click="store.generateFixtures()">Generate Fixtures</button>
    <button @click="store.playWeek()">Play Next Week</button>
    <button @click="store.playAll()">Play All</button>
    <button @click="store.reset()">Reset</button>

    <h2>Standings</h2>
    <pre>{{ store.standings }}</pre>

    <h2>Fixtures</h2>
    <pre>{{ store.fixtures }}</pre>

    <h2>Championship Predictions</h2>
    <pre>{{ store.championshipPredictions }}</pre>
  </main>
</template>