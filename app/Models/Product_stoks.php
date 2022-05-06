<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product_stoks extends Model
{
    use HasFactory;
    protected $table = "product_stoks";
    protected $fillable = [
        'stok_name'
    ];

    public function product_stok_details() { 
        return $this->hasMany(Product_stok_details::class, 'stok_id', 'id');
    }   

    public function product(){
        return $this->belongsToMany(Product::class, 'product_stok_details', 'stok_id', 'product_id')->withPivot('id');
    }

}
