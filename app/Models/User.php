<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    //User-Image relation
    public function image()
    {
        return $this->hasOne(Image::class,'user_id','id');
    }

    //User-Mobilenumber relation
    public function mobileNumbers()
    {
        return $this->hasMany(Mobilenumber::class,'user_id','id');
    }

    //Many-To-Many User-Todo Relation
     public function users()
     {
         return $this->belongsToMany(Todo::class,'user_todos','user_id','todo_id');
     }
}
