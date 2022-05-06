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
        'city_id',
        'province_id',
        'timeout',
        'address',
        'total', 
        'shipping_cost',
        'sub_total',
        'proof_of_payment',
        'code',
        'slug',
        'payment_token',
        'payment_url',
        'shipping_package',
        'status'
    ];

    public function couriers() { 
        return $this->hasMany(Couriers::class);
    }

    public function user() { 
        return $this->hasMany(User::class);
    }
}
