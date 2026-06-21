import { describe, it, expect, beforeEach } from 'vitest'
import { setActivePinia, createPinia } from 'pinia'
import { useInsiderLeagueStore } from './insiderLeague'

describe('insiderleague store', () => {
    beforeEach(() => {
        setActivePinia(createPinia())
    })

    it('counts zero played weeks when no fixtures exist', () => {
        const store = useInsiderLeagueStore()
        store.fixtures = []

        expect(store.playedWeeksCount).toBe(0)
    })

    it('counts only fully played weeks', () => {
        const store = useInsiderLeagueStore()
        store.fixtures = [
            // first week
            [
                { home: 'A', away: 'B', home_goals: 1, away_goals: 0, played: true },
                { home: 'C', away: 'D', home_goals: 2, away_goals: 2, played: true },
            ],
            // second week
            [
                { home: 'A', away: 'C', home_goals: 0, away_goals: 1, played: true },
                { home: 'B', away: 'D', home_goals: null, away_goals: null, played: false },
            ],
        ]

        // only first week is played and second week is partially played. so 1 should be returned
        expect(store.playedWeeksCount).toBe(1)
    })

    it('returns played weeks with correct numbers', () => {
        const store = useInsiderLeagueStore()
        store.fixtures = [
            // first week fully played
            [
                { home: 'A', away: 'B', home_goals: 1, away_goals: 0, played: true },
                { home: 'C', away: 'D', home_goals: 2, away_goals: 2, played: true },
            ],
            // second week fully played
            [
                { home: 'A', away: 'C', home_goals: 0, away_goals: 1, played: true },
                { home: 'B', away: 'D', home_goals: 3, away_goals: 1, played: true },
            ],
            // third week not played
            [
                { home: 'A', away: 'D', home_goals: null, away_goals: null, played: false },
                { home: 'B', away: 'C', home_goals: null, away_goals: null, played: false },
            ],
        ]

        const result = store.playedWeeks

        // only two weeks are played
        expect(result).toHaveLength(2)

        // newest week is second week as we reverse the array
        expect(result[0]?.week).toBe(2)
        expect(result[1]?.week).toBe(1)
    })
})