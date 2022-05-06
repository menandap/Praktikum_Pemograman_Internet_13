<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product_stok_details extends Model
{
    use HasFactory;
    protected $table = 'product_stok_details';
    protected $fillable = [
        'product_id',
        'stok_id',
        'stok'
    ];

    public function product_stoks() { 
        return $this->belongsTo(Product_stoks::class, 'stok_id', 'id');
    }   

    public function product() { 
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }   
}
