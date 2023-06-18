<?php

namespace App\Http\Controllers\Omen;

use App\Http\Controllers\Controller;
use App\Models\Fixture;
use App\Models\FixtureResult;
use App\Service\Fixture\FixtureService;
use App\Service\Prediction\PredictionService;
use Illuminate\Http\Request;

class FixtureController extends Controller
{
    public function index()
    {
        $handler = new FixtureService();
        return response()->api('Fixture generated');
    }

    public function generate()
    {
        $handler = new FixtureService();
        $handler->generate();
        return response()->api('Fixture generated');
    }

    public function getPotFixture($potId, $week)
    {
        $handler = new FixtureService();
        return response()->api($handler->getFixture($potId, $week));
    }

    public function simulateWeek()
    {

        $fixtureResult = FixtureResult::orderBy('week', 'desc')->first();

        if (is_null($fixtureResult)) {
            $selectedWeek = 1;
        } else {
            $selectedWeek = $fixtureResult->week + 1;
        }
        FixtureResult::where('week', $selectedWeek)->delete();

        $fixtures = Fixture::where('week', $selectedWeek)->get();
        $handler = new PredictionService();

        foreach ($fixtures as $fixture):
            $home = $handler->calculateTeamStrength($fixture, $fixture->homeTeam);
            $away = $handler->calculateTeamStrength($fixture, $fixture->homeTeam);

            $homeGoal = (int)($handler->generateRandomGoals($home) / 2);
            $awayGoal = (int)($handler->generateRandomGoals($away) / 2);

            $fixtureResultHandler = new FixtureResult();

            if ($homeGoal > $awayGoal) {
                $fixtureResultHandler->fill([
                    'fixture_id' => $fixture->id,
                    'home_team_id' => $fixture->homeTeam->id,
                    'away_team_id' => $fixture->awayTeam->id,
                    'home_team_score' => $homeGoal,
                    'away_team_score' => $awayGoal,
                    'week' => $selectedWeek,
                    'result' => 'win'
                ])->save();
            } else if ($homeGoal === $awayGoal) {
                $fixtureResultHandler->fill([
                    'fixture_id' => $fixture->id,
                    'home_team_id' => $fixture->homeTeam->id,
                    'away_team_id' => $fixture->awayTeam->id,
                    'home_team_score' => $homeGoal,
                    'away_team_score' => $awayGoal,
                    'week' => $selectedWeek,
                    'result' => 'draw'
                ])->save();
            } else {
                $fixtureResultHandler->fill([
                    'fixture_id' => $fixture->id,
                    'home_team_id' => $fixture->homeTeam->id,
                    'away_team_id' => $fixture->awayTeam->id,
                    'home_team_score' => $homeGoal,
                    'away_team_score' => $awayGoal,
                    'week' => $selectedWeek,
                    'result' => 'draw'
                ])->save();
            }

        endforeach;
        return response()->api(FixtureResult::where('week', '=', $selectedWeek)->get());
    }
}
