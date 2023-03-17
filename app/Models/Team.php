<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $fillable = ['name'];
    //Team-player Relation
    public function players()
    {
        return $this->hasMany(Player::class,'team_id','id')->with('run');
    }

    //Team-Run Relation
    public function run()
    {
        return $this->morphOne(Run::class,'runable');
    }
}
