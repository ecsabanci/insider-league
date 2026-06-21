import axios from 'axios'
import type { Standing, ChampionshipPrediction, AllWeekFixtures } from '@/types/types'

const api = axios.create({
  baseURL: import.meta.env.VITE_API_URL || 'http://localhost:8000/api',
})

export async function generateFixtures(): Promise<void> {
  await api.post('/fixtures/generate')
}

export async function playWeek(): Promise<void> {
  await api.post('/play-week')
}

export async function playAll(): Promise<void> {
  await api.post('/play-all')
}

export async function resetLeague(): Promise<void> {
  await api.post('/reset')
}

// getters and we use types to define the response
export async function getStandings(): Promise<Standing[]> {
  const response = await api.get<Standing[]>('/standings')
  return response.data
}

export async function getFixtures(): Promise<AllWeekFixtures> {
  const response = await api.get<AllWeekFixtures>('/fixtures')
  return response.data
}

export async function getChampionshipPredictions(): Promise<ChampionshipPrediction[]> {
  const response = await api.get<ChampionshipPrediction[]>('/championship-predictions')
  return response.data
}