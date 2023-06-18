<?php

namespace Database\Seeders;

use App\Models\Team;
use App\Models\TeamPoint;
use Illuminate\Database\Seeder;

class TeamsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Team::truncate();
        Team::withoutEvents(function () {
            Team::factory()->count(31)->create();
        });
        $teams = Team::inRandomOrder()->take(3)->get();
        foreach ($teams as $team):
            $team->holder = true;
            $team->saveQuietly();
        endforeach;
        Team::factory()->create([
            'name' => 'Adana Demirspor SK',
            'strength' => 99,
            'holder' => true
        ]);
        TeamPoint::truncate();
        $teams = Team::all();
        foreach ($teams as $team):
            $point = new TeamPoint();
            $point->fill([
                'team_id' => $team->id,
                'points' => 0,
                'played' => 0,
                'won' => 0,
                'drawn' => 0,
                'lost' => 0,
                'remaining_matches' => 6,
            ])->save();

        endforeach;
    }
}
