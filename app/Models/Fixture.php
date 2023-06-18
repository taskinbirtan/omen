<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fixture extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'fixture';

    protected $fillable = [
        'pot_id',
        'home_team_id',
        'away_team_id',
        'home_team_score',
        'away_team_score',
        'date',
        'week'
    ];

    public function homeTeam()
    {
        return $this->hasOne(Team::class, 'id', 'home_team_id');
    }
    public function awayTeam()
    {
        return $this->hasOne(Team::class, 'id', 'away_team_id');
    }

    public function fixtureResult($week = null)
    {
        if(is_null($week)) {
            return $this->hasMany(FixtureResult::class, 'fixture_id', 'id');
        } else {
            return $this->hasOne(FixtureResult::class, 'fixture_id', 'id')->where('week', $week);
        }
    }

    public function pot()
    {
        return $this->belongsTo(Pot::class);
    }

}
