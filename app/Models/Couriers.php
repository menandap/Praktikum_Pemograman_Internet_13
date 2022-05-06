<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Couriers extends Model
{
    use HasFactory;
    protected $table = "couriers";
    protected $fillable = [
        'courier'
    ];

    public function transactions() { 
        return $this->hasMany(Transactions::class);
    }

}
