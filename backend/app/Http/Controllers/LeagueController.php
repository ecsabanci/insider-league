<?php

namespace App\Http\Controllers;

use App\Services\LeagueService;

class LeagueController extends Controller
{
    // yine dependency injection yapıyoruz
    public function __construct(
        private LeagueService $leagueService,
    ) {}

    public function generateFixtures()
    {
        $this->leagueService->generateFixtures();

        return response()->json(['message' => 'Fixtures generated']);
    }

    public function playWeek()
    {
        $this->leagueService->playWeek();

        return response()->json(['message' => 'Week played']);
    }

    public function playAll()
    {
        $this->leagueService->playAll();

        return response()->json(['message' => 'All weeks played']);
    }

    public function reset()
    {
        $this->leagueService->reset();

        return response()->json(['message' => 'League reset']);
    }

    public function standings()
    {
        return response()->json($this->leagueService->getStandings());
    }

    public function fixtures()
    {
        return response()->json($this->leagueService->getFixtures());
    }

    public function predictions()
    {
        return response()->json($this->leagueService->getChampionshipPredictions());
    }
}