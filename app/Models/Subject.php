<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'code',
        'name',
    ];

    //Subject-Teacher Relation Many-to-Many
    public function teachers()
    {
        return $this->morphedByMany(Teacher::class,'courseable');
    }

    //Subject-Student Relation Many-to-Many
    public function students()
    {
        return $this->morphedByMany(Student::class,'courseable');
    }


}
