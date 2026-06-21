<script setup lang="ts">
import { onMounted } from 'vue'
import { useInsiderLeagueStore } from '@/stores/insiderLeague'
import StandingTable from '@/components/StandingTable.vue'
import FixturesList from '@/components/FixturesList.vue'

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
    <StandingTable :standings="store.standings" />

    <h2>Fixtures</h2>
    <FixturesList :fixtures="store.fixtures" />

    <h2>Predictions</h2>
    <pre>{{ store.championshipPredictions }}</pre>
  </main>
</template>