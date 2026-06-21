import { describe, it, expect } from 'vitest'
import { mount } from '@vue/test-utils'
import StandingTable from './StandingTable.vue'
import type { Standing } from '@/types/types'

const sampleStandings: Standing[] = [
    {
        team: { id: 1, name: 'Liverpool' },
        played: 2, won: 2, drawn: 0, lost: 0,
        goals_for: 4, goals_against: 1, goal_difference: 3, points: 6,
    },
    {
        team: { id: 2, name: 'Chelsea' },
        played: 2, won: 0, drawn: 0, lost: 2,
        goals_for: 1, goals_against: 4, goal_difference: -3, points: 0,
    },
]

describe('StandingsTable', () => {
    it('renders all teams', () => {
        const wrapper = mount(StandingTable, {
            props: { standings: sampleStandings },
        })

        expect(wrapper.text()).toContain('Liverpool')
        expect(wrapper.text()).toContain('Chelsea')
    })

    it('renders a row for each team', () => {
        const wrapper = mount(StandingTable, {
            props: { standings: sampleStandings },
        })

        const rows = wrapper.findAll('tbody tr')
        expect(rows).toHaveLength(2)
    })

    it('displays all points correctly', () => {
        const wrapper = mount(StandingTable, {
            props: { standings: sampleStandings },
        })

        const rows = wrapper.findAll('tbody tr')

        expect(rows[0]?.text()).toContain('Liverpool')
        expect(rows[0]?.find('.points')?.text()).toBe('6')

        expect(rows[1]?.text()).toContain('Chelsea')
        expect(rows[1]?.find('.points')?.text()).toBe('0')
    })
})