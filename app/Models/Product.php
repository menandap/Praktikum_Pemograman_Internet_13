<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = "products";
    protected $fillable = [
        'product_name',
        // 'slug',
        'price',
        'description',
        'product_rate',
        'weight'
        // 'kondisi'
    ];

    public function product_images() { 
        return $this->hasMany(Product_images::class, 'product_id','id');
    }   
  
    public function discounts() { 
        return $this->hasMany(Discounts::class, 'id_product','id');
    }   

    public function product_categories() {
        return $this->belongsToMany(Product_categories::class, 'product_category_details','product_id','category_id')->withPivot('id');
    }

    public function product_category_details() { 
        return $this->hasMany(Product_category_details::class, 'product_id','id');
    }   

    public function carts() { 
        return $this->hasMany(Carts::class);
    } 
    
    public function product_reviews() { 
        return $this->hasMany(Product_reviews::class);
    } 

    public function transaction_details() { 
        return $this->hasMany(Transaction_details::class);
    } 

}
