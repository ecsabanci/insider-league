import { defineStore } from 'pinia'
import { ref, computed } from 'vue'
import type { Standing, ChampionshipPrediction, AllWeekFixtures, PlayedWeek } from '@/types/types'
import * as api from '@/api/api'

export const useInsiderLeagueStore = defineStore('insiderLeague', () => {
  const standings = ref<Standing[]>([])
  const fixtures = ref<AllWeekFixtures>([])
  const championshipPredictions = ref<ChampionshipPrediction[]>([])
  const loading = ref(false)
  const currentPage = ref<'teams' | 'fixtures' | 'simulation'>('teams')
  const playedWeeksCount = computed(() => {
    return fixtures.value.filter(week => week.every(match => match.played)).length
  })
  const playedWeeks = computed(() => {
    const result: PlayedWeek[] = []
    fixtures.value.forEach((week, index) => {
      if (week.every((match) => match.played)) {
        result.push({ week: index + 1, matches: week })
      }
    })
    return result.reverse()
  })

  function goToFixtures() {
    currentPage.value = 'fixtures'
  }
  
  function goToSimulation() {
    currentPage.value = 'simulation'
  }

  function goToTeams() {
    currentPage.value = 'teams'
  }

  async function generateFixtures() {
    loading.value = true
    try {
      await api.generateFixtures()
      await refreshAll()
      goToFixtures()
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
      goToTeams()
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
    goToFixtures,
    goToSimulation,
    goToTeams,
    playedWeeksCount,
    currentPage,
    playedWeeks,
  }
})