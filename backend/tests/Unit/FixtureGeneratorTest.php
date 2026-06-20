<?php

namespace Tests\Unit;

use App\Services\FixtureGenerator;
use PHPUnit\Framework\TestCase;

class FixtureGeneratorTest extends TestCase
{
    public function test_generates_correct_number_of_weeks_for_four_teams(): void
    {
        $generator = new FixtureGenerator();
        $teams = [
            ['id' => 1, 'name' => 'A'],
            ['id' => 2, 'name' => 'B'],
            ['id' => 3, 'name' => 'C'],
            ['id' => 4, 'name' => 'D'],
        ];

        $rounds = $generator->generate($teams);

        $this->assertCount(6, $rounds);
    }

    public function test_each_week_has_two_matches_for_four_teams(): void
    {
        $generator = new FixtureGenerator();
        $teams = [
            ['id' => 1, 'name' => 'A'],
            ['id' => 2, 'name' => 'B'],
            ['id' => 3, 'name' => 'C'],
            ['id' => 4, 'name' => 'D'],
        ];

        $rounds = $generator->generate($teams);

        foreach ($rounds as $week) {
            $this->assertCount(2, $week);
        }
    }

    public function test_generates_twelve_matches_total_for_four_teams(): void
    {
        $generator = new FixtureGenerator();
        $teams = [
            ['id' => 1, 'name' => 'A'],
            ['id' => 2, 'name' => 'B'],
            ['id' => 3, 'name' => 'C'],
            ['id' => 4, 'name' => 'D'],
        ];

        $rounds = $generator->generate($teams);

        $totalMatches = 0;
        foreach ($rounds as $week) {
            $totalMatches += count($week);
        }

        $this->assertSame(12, $totalMatches);
    }
}