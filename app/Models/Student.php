<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'mobile',
    ];

    public function notices()
    {
        return $this->morphMany(Notice::class,'noticeable');
    }

    //Student-Subject Relation Many-to-Many
    public function subjects()
    {
        return $this->morphToMany(Subject::class,'courseable')->withTimestamps();
    }

    //get latest Notice
    public function latestNotice()
    {
        return $this->morphOne(Notice::class,'noticeable')->latestOfMany();
    }
}
