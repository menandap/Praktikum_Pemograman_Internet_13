<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discounts extends Model
{
    use HasFactory;
    protected $table = "discounts";
    protected $fillable = [
        'product_id',
        'percentage',
        'start',
        'end'
    ];

    public function product() { 
        return $this->belongsTo(Product::class, 'id_product', 'id');
    }
}
