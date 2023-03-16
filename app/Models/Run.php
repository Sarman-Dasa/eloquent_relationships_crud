<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Run extends Model
{
    use HasFactory;

    protected $fillable = 
    [
        'run',
    ];
    public function runable()
    {
        return $this->morphTo();
    }
}
