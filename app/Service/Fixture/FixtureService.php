<?php

namespace App\Service\Fixture;

use App\Models\Fixture;
use App\Models\FixtureResult;
use App\Models\Pot;
use App\Models\PotTeam;
use App\Models\Team;
use Database\Seeders\TeamsTableSeeder;

class FixtureService
{
    const WEEK = 8;

    public function build()
    {
        Fixture::truncate();
        PotTeam::truncate();
        (new TeamsTableSeeder())->run();
        FixtureResult::truncate();

        $teams = Team::all();
        $holderTeams = $teams->where('holder', true);

        $teams = $teams->where('holder', false);
        $teams = $teams->shuffle(time());

        $holderTeams->each(function ($team) {
            PotTeam::create([
                'pot_id' => 1,
                'team_id' => $team->id,
            ]);
        });


        $groupCounter = 0;
        $teams->shuffle()->each(function ($team) use (&$groupCounter) {
            static $groupIndex = 2;
            PotTeam::create([
                'pot_id' => $groupIndex,
                'team_id' => $team->id,
            ]);
            if ($groupCounter === 3) {
                $groupCounter = 0;
                $groupIndex++;
            } else {
                $groupCounter++;
            }
        });
    }

    public function generate()
    {
        $this->build();

        foreach (Pot::all() as $pot):
            $this->generateFixtures($pot->id);
        endforeach;

    }

    public function generateFixtures($potId)
    {
        $teams = PotTeam::where('pot_id', $potId)->get();

        $totalTeams = $teams->count();

        $totalWeeks = $totalTeams - 1;

        $fixtures = [];


        for ($week = 0; $week < $totalWeeks; $week++):
            $round = [];

            for ($i = 0; $i < $totalTeams / 2; $i++) :
                $homeTeamIndex = ($week + $i) % ($totalTeams - 1);
                $awayTeamIndex = ($totalTeams - 1 - $i + $week) % ($totalTeams - 1);

                if ($i == 0):
                    $awayTeamIndex = $totalTeams - 1;
                endif;

                $homeTeam = $teams[$homeTeamIndex];
                $awayTeam = $teams[$awayTeamIndex];

                $round[] = [
                    'pot_id' => $potId,
                    'home_team_id' => $homeTeam->team_id,
                    'away_team_id' => $awayTeam->team_id,
                    'week' => $week + 1,
                    'date' => now()->addDays($week * 7),
                ];
                $round[] = [
                    'pot_id' => $potId,
                    'away_team_id' => $homeTeam->team_id,
                    'home_team_id' => $awayTeam->team_id,
                    'week' => (6- ($week)),
                    'date' => now()->addDays($week * 7 * 2),
                ];
            endfor;

            $fixtures[] = $round;
        endfor;

        foreach ($fixtures as $round):
            foreach ($round as $fixtureData):
                Fixture::create($fixtureData);
            endforeach;
        endforeach;

    }

    public function getFixture($potId, $week = null)
    {
        if (is_null($week)) {
            return Fixture::with(['homeTeam', 'awayTeam', 'fixtureResult'])->where('pot_id', $potId)->orderBy('week')->get();
        } else {
            return Fixture::with(['homeTeam', 'awayTeam', 'fixtureResult'])->where('pot_id', $potId)->orderBy('week')
                ->where('week', $week)->get();
        }
    }

}
