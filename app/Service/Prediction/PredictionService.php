<?php

namespace App\Service\Prediction;

use App\Models\Fixture;
use App\Models\Pot;
use App\Models\PotTeam;
use App\Models\Team;
use App\Models\TeamPoint;

class PredictionService
{
    use Concerns\InteractsWithTeams;

    public static function calculateChampionshipPercentage($teamId)
    {
        $team = Team::findOrFail($teamId);
        $teamPoints = TeamPoint::where('team_id', $teamId)->first();

        if (!$teamPoints) {
            return 0;
        }

        $leaderTeam = Team::where('is_leader', true)->first();

        if ($team->is_leader):
            return 100;
        elseif ($team->points->points == 0):
            return 0;
        elseif(is_null($leaderTeam)):
            return 0;
        endif;


        $remainingPoints = ($leaderTeam->points - $teamPoints->points) + (3 * $teamPoints->remaining_matches);

        $totalPoints = TeamPoint::sum('points');

        $totalRemainingPoints = TeamPoint::sum('remaining_matches') * 3;

        $championshipPercentage = ($totalPoints + $totalRemainingPoints - $remainingPoints) / ($totalPoints + $totalRemainingPoints) * 100;

        return round($championshipPercentage, 2);
    }
}
