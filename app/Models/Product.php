<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = "products";
    protected $fillable = [
        'user_id',
        'product_name',
        'slug',
        'price',
        'description',
        'product_rate',
        'stock',
        'weight',
        'kondisi'
    ];

}
