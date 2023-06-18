<?php

namespace App\Observers;

use App\Models\FixtureResult;
use App\Models\TeamPoint;

class FixtureResultObserver
{
    /**
     * Handle the FixtureResult "created" event.
     */
    public function created(FixtureResult $fixtureResult): void
    {
        $homeTeam = TeamPoint::where('team_id', $fixtureResult->home_team_id)->first();
        $awayTeam = TeamPoint::where('team_id', $fixtureResult->away_team_id)->first();
        if ($fixtureResult->result !== 'draw') {
            if ($fixtureResult->result === 'win') {
                $homeTeam->fill([
                    'points' => $homeTeam->points + 3,
                    'won' => $homeTeam->won + 1
                ])->save();
                $awayTeam->fill([
                    'lost' => $awayTeam->lost + 1
                ])->save();
            } else {

                $awayTeam->fill([
                    'points' => $awayTeam->points + 3,
                    'won' => $awayTeam->won + 1
                ])->save();
                $homeTeam->fill([
                    'lost' => $homeTeam->lost + 1,
                ])->save();
            }
        } else {
            $awayTeam->fill([
                'drawn' => $awayTeam->drawn + 1,
            ])->save();
            $homeTeam->fill([
                'drawn' => $homeTeam->drawn + 1,
                'point' => $homeTeam->points + 1
            ])->save();
        }
        $homeTeam = TeamPoint::where('team_id', $fixtureResult->home_team_id)->first();
        $awayTeam = TeamPoint::where('team_id', $fixtureResult->away_team_id)->first();

        $homeTeam->fill([
            'played' => $homeTeam->played + 1,
            'remaining_matches' => $homeTeam->remaining_matches - 1,
        ])->save();
        $awayTeam->fill([
            'played' => $homeTeam->played + 1,
            'remaining_matches' => $homeTeam->remaining_matches - 1,
        ])->save();
    }

    /**
     * Handle the FixtureResult "updated" event.
     */
    public function updated(FixtureResult $fixtureResult): void
    {
        //
    }

    /**
     * Handle the FixtureResult "deleted" event.
     */
    public function deleted(FixtureResult $fixtureResult): void
    {
        //
    }

    /**
     * Handle the FixtureResult "restored" event.
     */
    public function restored(FixtureResult $fixtureResult): void
    {
        //
    }

    /**
     * Handle the FixtureResult "force deleted" event.
     */
    public function forceDeleted(FixtureResult $fixtureResult): void
    {
        //
    }
}
