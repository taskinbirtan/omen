<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FixtureResult extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'fixture_result';

    protected $fillable = [
        'fixture_id',
        'home_team_id',
        'away_team_id',
        'home_team_score',
        'away_team_score',
        'week',
        'result'
    ];

    public function fixture()
    {
        return $this->belongsTo(Fixture::class);
    }

    public function homeTeam()
    {
        return $this->belongsTo(Team::class, 'home_team_id');
    }

    public function awayTeam()
    {
        return $this->belongsTo(Team::class, 'away_team_id');
    }

    public function homeTeamPoint()
    {
        return $this->belongsTo(TeamPoint::class, 'home_team_id', 'team_id');
    }

    public function awayTeamPoint()
    {
        return $this->belongsTo(TeamPoint::class, 'away_team_id', 'team_id');
    }

}
