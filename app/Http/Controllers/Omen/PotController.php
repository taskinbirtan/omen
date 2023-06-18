<?php

namespace App\Http\Controllers\Omen;

use App\Http\Controllers\Controller;
use App\Service\Fixture\FixtureService;
use App\Service\Prediction\PredictionService;
use Illuminate\Http\Request;

class PotController extends Controller
{
    public function index()
    {
        return response()->api(\App\Models\Pot::with('teams.team.points')->get()->toArray());
    }

    public function listTeamsByPot($id)
    {
        $pot = \App\Models\Pot::where('id', $id)->with('teams.team.points')->first();
        $pot = $pot->teams->map(function ($team) {
            $team->prediction = PredictionService::calculateChampionshipPercentage($team->id);
            return $team;
        });
        return response()->api($pot);
    }

    public function weeklyFixture($potId)
    {
        $handler = new FixtureService();
        return response()->api($handler->getFixture($potId)->toArray());
    }
}
