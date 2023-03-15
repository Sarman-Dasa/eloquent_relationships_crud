<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['quantity','product_id'];

    //Order-Product relation
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    //Order-Category relation
    public function category()
    {
       return $this->hasOneThrough(category::class,Product::class,'category_id','id','product_id','id');
    }


}
