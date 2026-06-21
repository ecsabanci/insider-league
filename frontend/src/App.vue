<script setup lang="ts">
import { onMounted } from 'vue'
import { useInsiderLeagueStore } from '@/stores/insiderLeague'
import StandingTable from '@/components/StandingTable.vue'
import FixturesList from '@/components/FixturesList.vue'
import PredictionsPanel from '@/components/PredictionsPanel.vue'
import WeekResults from '@/components/WeekResults.vue'
import Buttons from '@/components/Buttons.vue'

const store = useInsiderLeagueStore()

onMounted(() => {
  store.refreshAll()
})
</script>

<template>
  <main style="padding: 20px; font-family: sans-serif">
    <h1>Insider One Champions League</h1>

    <div v-if="store.loading" class="loading-bar"></div>

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

      <div class="sim-grid">
        <div class="sim-col">
          <h3>League Table</h3>
          <StandingTable :standings="store.standings" />
        </div>

        <div class="sim-col">
          <h3>Week Results</h3>
          <WeekResults :weeks="store.playedWeeks" />
        </div>

        <div class="sim-col">
          <h3>Championship Predictions</h3>
          <PredictionsPanel
            v-if="store.playedWeeksCount >= 4"
            :predictions="store.championshipPredictions"
          />
          <p v-else class="hint">Tahminler 4. haftadan sonra gösterilir.</p>
        </div>
      </div>

      <Buttons
        :loading="store.loading"
        @play-week="store.playWeek()"
        @play-all="store.playAll()"
        @reset="store.reset()"
      />
    </section>
  </main>
</template>

<style scoped>
.loading-bar {
  position: fixed;
  top: 0;
  left: 0;
  height: 3px;
  width: 100%;
  background: var(--accent);
  animation: pulse 1s ease-in-out infinite;
  z-index: 100;
}

.sim-grid {
  display: flex;
  gap: 20px;
  align-items: flex-start;
  margin-bottom: 24px;
}

.sim-col {
  flex: 1;
  min-width: 0;
}

.hint {
  color: var(--color-muted);
  font-size: 13px;
  padding: 12px;
  border: 2px solid var(--color-border);
  background: var(--color-surface);
}

@keyframes pulse {
  0%, 100% { opacity: 0.4; }
  50% { opacity: 1; }
}
</style>