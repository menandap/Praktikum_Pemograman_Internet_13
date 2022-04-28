<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product_category_details extends Model
{
    use HasFactory;
    protected $table = "product_categories";
    protected $fillable = [
        'product_id',
        'category_id'
    ];
}
