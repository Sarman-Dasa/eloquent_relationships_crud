<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name','price','expired_date','category_id'];

    //Product-Category relation
    public function category()
    {
        return $this->belongsTo(Category::class,'category_id','id');
    }

    //Product-Order relation
    public function orders()
    {
        return $this->hasMany(Order::class,'product_id','id');
    }
}