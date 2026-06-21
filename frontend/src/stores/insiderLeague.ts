import { defineStore } from 'pinia'
import { ref } from 'vue'
import type { Standing, ChampionshipPrediction, AllWeekFixtures } from '@/types/types'
import * as api from '@/api/api'

export const useInsiderLeagueStore = defineStore('insiderLeague', () => {
  const standings = ref<Standing[]>([])
  const fixtures = ref<AllWeekFixtures>([])
  const championshipPredictions = ref<ChampionshipPrediction[]>([])
  const loading = ref(false)

  async function generateFixtures() {
    loading.value = true
    try {
      await api.generateFixtures()
      await refreshAll()
    } finally {
      loading.value = false
    }
  }

  async function playWeek() {
    loading.value = true
    try {
      await api.playWeek()
      await refreshAll()
    } finally {
      loading.value = false
    }
  }

  async function playAll() {
    loading.value = true
    try {
      await api.playAll()
      await refreshAll()
    } finally {
      loading.value = false
    }
  }

  async function reset() {
    loading.value = true
    try {
      await api.resetLeague()
      await refreshAll()
    } finally {
      loading.value = false
    }
  }

  async function refreshAll() {
    // parallel requests
    const [s, f, p] = await Promise.all([
      api.getStandings(),
      api.getFixtures(),
      api.getChampionshipPredictions(),
    ])
    standings.value = s
    fixtures.value = f
    championshipPredictions.value = p
  }

  return {
    standings,
    fixtures,
    championshipPredictions,
    loading,
    generateFixtures,
    playWeek,
    playAll,
    reset,
    refreshAll,
  }
})