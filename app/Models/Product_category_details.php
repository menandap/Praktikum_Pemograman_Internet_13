<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product_category_details extends Model
{
    use HasFactory;
    protected $table = 'product_category_details';
    protected $fillable = [
        'product_id',
        'category_id'
    ];

    public function product_categories() { 
        return $this->belongsTo(Product_categories::class, 'category_id', 'id');
    }   

    public function product() { 
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }   
}
