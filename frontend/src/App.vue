<script setup lang="ts">
import { onMounted } from 'vue'
import { useInsiderLeagueStore } from '@/stores/insiderLeague'
import StandingTable from '@/components/StandingTable.vue'
import FixturesList from '@/components/FixturesList.vue'
import PredictionsPanel from '@/components/PredictionsPanel.vue'
import Buttons from '@/components/Buttons.vue'

const store = useInsiderLeagueStore()

onMounted(() => {
  store.refreshAll()
})
</script>

<template>
  <main style="padding: 20px; font-family: sans-serif">
    <h1>Insider One Champions League</h1>

    <p v-if="store.loading">Loading...</p>

    <Buttons
      :loading="store.loading"
      @generate="store.generateFixtures()"
      @play-week="store.playWeek()"
      @play-all="store.playAll()"
      @reset="store.reset()"
    />

    <h2>Standings</h2>
    <StandingTable :standings="store.standings" />

    <h2>Fixtures</h2>
    <FixturesList :fixtures="store.fixtures" />

    <h2>Predictions</h2>
    <PredictionsPanel :predictions="store.championshipPredictions" />
  </main>
</template>