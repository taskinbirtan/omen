<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'team';
    protected $fillable = [
        'name',
        'strength',
        'holder',
        'is_leader',
    ];

    public function points()
    {
        return $this->hasOne(TeamPoint::class);
    }

    public function pots()
    {
        return $this->belongsTo(PotTeam::class);
    }


}
