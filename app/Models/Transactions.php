<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transactions extends Model
{
    use HasFactory;
    protected $table = "transactions";
    protected $fillable = [
        'user_id',
        'courier_id',
        'regency',
        'province',
        'timeout',
        'address',
        'total', 
        'shipping_cost',
        'subtotal',
        'proof_of_payment',
        'code',
        'slug',
        'payment_token',
        'payment_url',
        'shipping_package',
        'status'
    ];

    public function courier()
    {
        return $this->belongsTo(Couriers::class);
    }


    public function user() { 
        return $this->belongsTo(User::class);
    }

    public function transaction_detail()
    {
        return $this->hasMany(Transaction_details::class, "transaction_id");
    }
}
