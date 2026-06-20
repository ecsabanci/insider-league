<?php

namespace App\Services;

class FixtureGenerator
{
    public function generate(array $teams): array
    {
        $teamCount = count($teams);
        $rounds = [];

        $rotating = $teams;

        for ($week = 0; $week < $teamCount - 1; $week++) {
            $weekMatches = [];
    
            for ($i = 0; $i < $teamCount / 2; $i++) {
                $home = $rotating[$i];
                $away = $rotating[$teamCount - 1 - $i];
                $weekMatches[] = [
                    'home' => $home,
                    'away' => $away,
                ];
            }
    
            $rounds[] = $weekMatches;
    
            // ilk eleman sabit gerisi dönecek yani circle method
            $fixed = array_shift($rotating); // ilk elemanı çıkar
            $last = array_pop($rotating); // son elemanı at
            array_unshift($rotating, $last); // son elemanı başa al
            array_unshift($rotating, $fixed); // ilk elemanı başa al
        }

        $secondHalf = [];

        foreach ($rounds as $week) {
            $reversedWeek = [];
            foreach ($week as $match) {
                $reversedWeek[] = [
                    'home' => $match['away'],
                    'away' => $match['home'],
                ];
            }
            $secondHalf[] = $reversedWeek;
        }
    
        return array_merge($rounds, $secondHalf);
    }
}