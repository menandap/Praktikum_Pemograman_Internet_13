<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction_details extends Model
{
    use HasFactory;
    protected $table = "transaction_details";
    protected $fillable = [
        'transaction_id',
        'product_id',
        'stok',
        'qty',
        'discount',
        'selling_price'
    ];

    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function transactions() { 
        return $this->belongsTo(Transactions::class);
    }
}
