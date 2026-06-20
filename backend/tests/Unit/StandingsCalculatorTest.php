<?php

namespace Tests\Unit;

use App\Services\StandingsCalculator;
use PHPUnit\Framework\TestCase;

class StandingsCalculatorTest extends TestCase
{
    private function teams(): array
    {
        return [
            ['id' => 1, 'name' => 'Liverpool'],
            ['id' => 2, 'name' => 'Chelsea'],
            ['id' => 3, 'name' => 'Arsenal'],
        ];
    }

    public function test_calculates_points_correctly(): void
    {
        $calculator = new StandingsCalculator();

        $matches = [
            ['home_id' => 1, 'away_id' => 2, 'home_goals' => 3, 'away_goals' => 1, 'played' => true],
            ['home_id' => 2, 'away_id' => 3, 'home_goals' => 2, 'away_goals' => 2, 'played' => true],
            ['home_id' => 3, 'away_id' => 1, 'home_goals' => 0, 'away_goals' => 1, 'played' => true],
        ];

        $table = $calculator->calculate($this->teams(), $matches);

        $this->assertSame('Liverpool', $table[0]['team']['name']);
        $this->assertSame(6, $table[0]['points']);
    }

    public function test_orders_by_goal_difference_when_points_equal(): void
    {
        $calculator = new StandingsCalculator();

        $matches = [
            ['home_id' => 1, 'away_id' => 2, 'home_goals' => 3, 'away_goals' => 1, 'played' => true],
            ['home_id' => 2, 'away_id' => 3, 'home_goals' => 2, 'away_goals' => 2, 'played' => true],
            ['home_id' => 3, 'away_id' => 1, 'home_goals' => 0, 'away_goals' => 1, 'played' => true],
        ];

        $table = $calculator->calculate($this->teams(), $matches);

        $this->assertSame('Arsenal', $table[1]['team']['name']);
        $this->assertSame('Chelsea', $table[2]['team']['name']);
    }

    public function test_ignores_unplayed_matches(): void
    {
        $calculator = new StandingsCalculator();

        $matches = [
            ['home_id' => 1, 'away_id' => 2, 'home_goals' => null, 'away_goals' => null, 'played' => false],
        ];

        $table = $calculator->calculate($this->teams(), $matches);

        foreach ($table as $row) {
            $this->assertSame(0, $row['points']);
            $this->assertSame(0, $row['played']);
        }
    }
}