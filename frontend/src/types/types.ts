export interface Team {
    id: number
    name: string
    strength?: number // optional because e.g. getStandings() doesn't need strength but getChampionshipPredictions() does
}

export interface Standing {
    team: Team
    played: number
    won: number
    drawn: number
    lost: number
    goals_for: number
    goals_against: number
    goal_difference: number
    points: number
}

export interface ChampionshipPrediction {
    team: Team
    percentage: number
}

export interface FixtureMatch {
    home: string
    away: string
    home_goals: number | null
    away_goals: number | null
    played: boolean
}

export type AllWeekFixtures = FixtureMatch[][] // 2D array because each week has two matches