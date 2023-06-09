<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ]; 

    //Category-Product relation one-to-many
    public function products()
    {
        return $this->hasMany(Product::class,'category_id','id');
    }

    //Category-Order relation  Has Many Through
    public function orders()
    {
        return $this->hasManyThrough(Order::class,Product::class,'category_id','product_id');
    }
}
