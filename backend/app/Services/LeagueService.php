<?php

namespace App\Services;

use App\Models\Fixture;
use App\Models\Team;

class LeagueService
{
    public function __construct(
        // dependencies injection yapıyoruz ki test etmesi kolay olsun
        private FixtureGenerator $fixtureGenerator,
        private MatchSimulator $matchSimulator,
        private StandingsCalculator $standingsCalculator,
    ) {}

    public function generateFixtures(): void
    {
        Fixture::query()->delete(); // eğer varsa eski fikstürü sil

        $teams = Team::all()->map(fn ($team) => [
            'id' => $team->id,
            'name' => $team->name,
        ])->all();

        $rounds = $this->fixtureGenerator->generate($teams);

        foreach ($rounds as $weekIndex => $weekMatches) {
            foreach ($weekMatches as $match) {
                Fixture::create([
                    'week' => $weekIndex + 1,
                    'home_team_id' => $match['home']['id'],
                    'away_team_id' => $match['away']['id'],
                    'played' => false,
                ]);
            }
        }
    }

    public function playWeek(): void
    {
        $nextWeek = Fixture::query()
            ->where('played', false)
            ->min('week');

        if ($nextWeek === null) {
            return; // oynanacak hafta kalmadı
        }

        $fixtures = Fixture::query()
            ->where('week', $nextWeek)
            ->where('played', false)
            ->get();

        foreach ($fixtures as $fixture) {
            $homeStrength = $fixture->homeTeam->strength;
            $awayStrength = $fixture->awayTeam->strength;

            $result = $this->matchSimulator->simulate($homeStrength, $awayStrength);

            $fixture->update([
                'home_goals' => $result['home_goals'],
                'away_goals' => $result['away_goals'],
                'played' => true,
            ]);
        }
    }

    public function getStandings(): array
    {
        $teams = Team::all()->map(fn ($team) => [
            'id' => $team->id,
            'name' => $team->name,
        ])->all();

        $matches = Fixture::query()->get()->map(fn ($fixture) => [
            'home_id' => $fixture->home_team_id,
            'away_id' => $fixture->away_team_id,
            'home_goals' => $fixture->home_goals,
            'away_goals' => $fixture->away_goals,
            'played' => $fixture->played,
        ])->all();

        return $this->standingsCalculator->calculate($teams, $matches);
    }
}