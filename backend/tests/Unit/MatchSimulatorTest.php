<?php

namespace Tests\Unit;

use App\Services\MatchSimulator;
use PHPUnit\Framework\TestCase;

class MatchSimulatorTest extends TestCase
{
    public function test_goals_are_never_below_zero(): void
    {
        $simulator = new MatchSimulator();

        for ($i = 0; $i < 100; $i++) {
            $result = $simulator->simulate(80, 70);

            $this->assertGreaterThanOrEqual(0, $result['home_goals']);
            $this->assertGreaterThanOrEqual(0, $result['away_goals']);
        }
    }

    public function test_returns_integer_goals(): void
    {
        $simulator = new MatchSimulator();

        $result = $simulator->simulate(80, 70);

        $this->assertIsInt($result['home_goals']);
        $this->assertIsInt($result['away_goals']);
    }

    public function test_stronger_team_wins_more(): void
    {
        $simulator = new MatchSimulator();
        $strongWins = 0;
        $weakWins = 0;

        for ($i = 0; $i < 1000; $i++) {
            $result = $simulator->simulate(100, 20);

            if ($result['home_goals'] > $result['away_goals']) {
                $strongWins++;
            } elseif ($result['home_goals'] < $result['away_goals']) {
                $weakWins++;
            }
        }

        $this->assertGreaterThan($weakWins, $strongWins);
    }
}