<?php

namespace App\Services;

class ChampionshipPredictor
{
    private const SIMULATION_COUNT = 1000;

    public function __construct(
        private MatchSimulator $matchSimulator,
        private StandingsCalculator $standingsCalculator,
    ) {}

    public function predict(array $teams, array $playedMatches, array $remainingMatches): array
    {
        $championCounts = [];
        foreach ($teams as $team) {
            $championCounts[$team['id']] = 0;
        }

        for ($i = 0; $i < self::SIMULATION_COUNT; $i++) {
            $simulatedMatches = $this->simulateRemaining($teams, $remainingMatches);
            $allMatches = array_merge($playedMatches, $simulatedMatches);

            $table = $this->standingsCalculator->calculate($teams, $allMatches);
            $champion = $table[0]; // en üstteki takım

            $championCounts[$champion['team']['id']]++;
        }

        $predictions = [];
        foreach ($teams as $team) {
            $predictions[] = [
                'team' => $team,
                'percentage' => round(($championCounts[$team['id']] / self::SIMULATION_COUNT) * 100, 1),
            ];
        }

        // yüzdeye göre büyükten küçüğe sırala
        usort($predictions, fn ($a, $b) => $b['percentage'] <=> $a['percentage']);

        return $predictions;
    }

    private function simulateRemaining(array $teams, array $remainingMatches): array
    {
        $strengthById = [];
        foreach ($teams as $team) {
            $strengthById[$team['id']] = $team['strength'];
        }

        $simulated = [];
        foreach ($remainingMatches as $match) {
            $result = $this->matchSimulator->simulate(
                $strengthById[$match['home_id']],
                $strengthById[$match['away_id']]
            );

            $simulated[] = [
                'home_id' => $match['home_id'],
                'away_id' => $match['away_id'],
                'home_goals' => $result['home_goals'],
                'away_goals' => $result['away_goals'],
                'played' => true,
            ];
        }

        return $simulated;
    }
}