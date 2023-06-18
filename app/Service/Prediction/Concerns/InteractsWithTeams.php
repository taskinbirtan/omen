<?php

namespace App\Service\Prediction\Concerns;

use App\Models\Fixture;
use App\Models\Team;

trait InteractsWithTeams
{

    public function calculateTeamStrength(Fixture $fixture, Team $team)
    {
        $power = $team->strength;
        if ($fixture->home_team_id === $team->id):
            $factors = [
                'supporter_strength' => rand(8, 10) / 10,
                'goalkeeper_factor' => rand(5, 10) / 10,
            ];
        else:
            $factors = [
                'supporter_strength' => rand(5, 10) / 10,
                'goalkeeper_factor' => rand(5, 10) / 10,
            ];
        endif;

        foreach ($factors as $factor):
            $power *= $factor;
        endforeach;

        return $power;
    }

    protected function generateGoalCount($team1Strength, $team2Strength)
    {
        // Güç seviyelerine bağlı olarak gol üretme şansını hesapla
        $team1GoalChance = ($team1Strength) / 10;
        $team2GoalChance = ($team2Strength) / 10;

        // Rastgele gol sayısı üret
        $team1Goals = $this->generateRandomGoals($team1GoalChance);
        $team2Goals = $this->generateRandomGoals($team2GoalChance);

        return [$team1Goals, $team2Goals];
    }

    /**
     * Belirli bir gol şansına dayalı olarak rastgele bir gol sayısı üretir.
     *
     * @param float $goalChance Gol şansı (0 ile 10 arasında bir sayı)
     * @return int Rastgele üretilen gol sayısı
     */
    function generateRandomGoals($goalChance)
    {
        $goals = 0;

        // Gol şansına bağlı olarak rastgele gol sayısı üret
        for ($i = 0; $i < 10; $i++):
            $randomNumber = mt_rand(0, 100) / 10;

            if ($randomNumber <= $goalChance):
                $goals++;
            endif;
        endfor;

        return $goals;
    }


}
