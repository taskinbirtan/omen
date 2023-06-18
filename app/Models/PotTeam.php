<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PotTeam extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'pot_team';

    protected $fillable = [
        'pot_id',
        'team_id',
    ];


    public function pot()
    {
        return $this->belongsTo(Pot::class);
    }

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function point()
    {
        return $this->hasOne(TeamPoint::class, 'team_id', 'id');
    }
}
