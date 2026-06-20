<?php

namespace App\Services;

class StandingsCalculator
{
    public function calculate(array $teams, array $matches): array
    {
        // her takım için boş satır
        $table = [];
        foreach ($teams as $team) {
            $table[$team['id']] = [
                'team' => $team,
                'played' => 0,
                'won' => 0,
                'drawn' => 0,
                'lost' => 0,
                'goals_for' => 0,
                'goals_against' => 0,
                'goal_difference' => 0,
                'points' => 0,
            ];
        }

        // oynanan maçı kaydet ve ilgili takımları güncelle
        foreach ($matches as $match) {
            if (!$match['played']) {
                continue;
            }

            $home = $match['home_id'];
            $away = $match['away_id'];
            $homeGoals = $match['home_goals'];
            $awayGoals = $match['away_goals'];

            $table[$home]['played']++;
            $table[$away]['played']++;

            $table[$home]['goals_for'] += $homeGoals;
            $table[$home]['goals_against'] += $awayGoals;
            $table[$away]['goals_for'] += $awayGoals;
            $table[$away]['goals_against'] += $homeGoals;

            if ($homeGoals > $awayGoals) {
                $table[$home]['won']++;
                $table[$away]['lost']++;
                $table[$home]['points'] += 3;
            } elseif ($homeGoals < $awayGoals) {
                $table[$away]['won']++;
                $table[$home]['lost']++;
                $table[$away]['points'] += 3;
            } else {
                $table[$home]['drawn']++;
                $table[$away]['drawn']++;
                $table[$home]['points'] += 1;
                $table[$away]['points'] += 1;
            }
        }

        // averaj hesabı
        foreach ($table as $id => $row) {
            $table[$id]['goal_difference'] = $row['goals_for'] - $row['goals_against'];
        }

        // sıralama mantığı. önce puan sonra averaj sonra atılan gole göre
        usort($table, function ($a, $b) {
            return [$b['points'], $b['goal_difference'], $b['goals_for']]
                <=> [$a['points'], $a['goal_difference'], $a['goals_for']];
        });

        return $table;
    }
}