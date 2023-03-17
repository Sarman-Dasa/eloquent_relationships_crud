<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'team_id',
    ];

    //Player-Team Relation
    public function team()
    {
        return $this->belongsTo(Team::class,'team_id','id');
    }

    //Player-Run Relation 
    public function run()
    {
        return $this->morphOne(Run::class,'runable');
    }
}
