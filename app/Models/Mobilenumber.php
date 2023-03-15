<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mobilenumber extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'user_id',
    ];

    //Mobilenumber-User Relation
    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
}
