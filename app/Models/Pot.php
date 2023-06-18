<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pot extends Model
{
    use HasFactory;

    protected $table = 'pot';
    public $timestamps = false;

    public function teams()
    {
        return $this->hasMany(PotTeam::class);
    }

}
