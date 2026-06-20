<?php

namespace App\Services;

class MatchSimulator
{
    private const HOME_ADVANTAGE = 1.10;
    private const GOAL_SCALING = 3;

    public function simulate(int $homeStrength, int $awayStrength): array
    {
        $adjustedHome = $homeStrength * self::HOME_ADVANTAGE;
        $totalStrength = $adjustedHome + $awayStrength;

        $homeGoals = $this->generateGoals($adjustedHome, $totalStrength);
        $awayGoals = $this->generateGoals($awayStrength, $totalStrength);

        return [
            'home_goals' => $homeGoals,
            'away_goals' => $awayGoals,
        ];
    }

    private function generateGoals(float $teamStrength, float $totalStrength): int
    {
        // güç oranına göre beklenen gol. Gücü oransal yapmak için takımGücü / toplamGüc
        $expectedGoals = ($teamStrength / $totalStrength) * self::GOAL_SCALING;

        $maxGoals = (int) round($expectedGoals) + 1;

        return random_int(0, max($maxGoals, 1)); // 0 ile maxGoals arasında rastgele bir sayı
    }
}