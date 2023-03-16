<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
    ];

    //Todo-User module relationship created_at
    // public function users()
    // {
    //     return $this->belongsToMany(User::class,'user_todos','todo_id','user_id')->withTimestamps();
    // }
    
    //Todo-User module relationship created_at
    public function users()
    {
        return $this->belongsToMany(User::class,'user_todos','todo_id','user_id')->withPivot('created_at');
    }
}