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

    <section v-if="store.currentPage === 'teams'">
      <h2>Tournament Teams</h2>
      <StandingTable :standings="store.standings" />
      <button :disabled="store.loading" @click="store.generateFixtures()">
        Generate Fixtures
      </button>
    </section>

    <section v-else-if="store.currentPage === 'fixtures'">
      <h2>Generated Fixtures</h2>
      <FixturesList :fixtures="store.fixtures" />
      <button :disabled="store.loading" @click="store.goToSimulation()">
        Start Simulation
      </button>
    </section>

    <section v-else-if="store.currentPage === 'simulation'">
      <h2>Simulation</h2>

      <StandingTable :standings="store.standings" />

      <h3>Championship Predictions</h3>
      <PredictionsPanel
        v-if="store.playedWeeksCount >= 4"
        :predictions="store.championshipPredictions"
      />
      <p v-else>Şampiyonluk tahminleri 4. haftadan sonra gösterilir.</p>

      <Buttons
        :loading="store.loading"
        @play-week="store.playWeek()"
        @play-all="store.playAll()"
        @reset="store.reset()"
      />
    </section>
  </main>
</template>