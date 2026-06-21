import { describe, it, expect } from 'vitest'
import { mount } from '@vue/test-utils'
import PredictionsPanel from './PredictionsPanel.vue'
import type { ChampionshipPrediction } from '@/types/types'

const samplePredictions: ChampionshipPrediction[] = [
  { team: { id: 1, name: 'Manchester City' }, percentage: 70 },
  { team: { id: 2, name: 'Chelsea' }, percentage: 5 },
]

describe('PredictionsPanel', () => {
  it('renders all teams with their percentages', () => {
    const wrapper = mount(PredictionsPanel, {
      props: { predictions: samplePredictions },
    })

    expect(wrapper.text()).toContain('Manchester City')
    expect(wrapper.text()).toContain('70')
    expect(wrapper.text()).toContain('Chelsea')
    expect(wrapper.text()).toContain('5')
  })

  it('renders a row for each prediction', () => {
    const wrapper = mount(PredictionsPanel, {
      props: { predictions: samplePredictions },
    })

    const rows = wrapper.findAll('tbody tr')
    expect(rows).toHaveLength(2)
  })
})