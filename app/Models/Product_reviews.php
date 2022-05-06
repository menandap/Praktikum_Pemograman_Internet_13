<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product_reviews extends Model
{
    use HasFactory;
    protected $table = "product_reviews";
    protected $fillable = [
        'product_id',
        'user_id',
        'rate',
        'content'    
    ];

    public function product() { 
        return $this->belongsTo(Product::class);
    }

    public function response() { 
        return $this->hasMany(Responses::class);
    }

    public function user() { 
        return $this->belongsTo(User::class);
    }
}
