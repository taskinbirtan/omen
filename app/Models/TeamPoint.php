<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamPoint extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'team_point';

    protected $fillable = [
        'team_id',
        'points',
        'played',
        'won',
        'drawn',
        'lost',
        'remaining_matches'
    ];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }
}
