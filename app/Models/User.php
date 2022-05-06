<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class User extends Authenticatable
{
    use HasFactory, Notifiable;
    protected $table = "users";
    protected $fillable = [
        'name',
        'email',
        'profile_image',
        'status',
        'email_verified_at',
        'password',
        'remember_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function product_reviews() {
        return $this->hasMany(Product_reviews::class);
    }

    public function carts() {
        return $this->hasMany(Carts::class);
    }

    public function user_notification() {
        return $this->hasMany(User_notifications::class);
    }

    public function transactions() {
        return $this->hasMany(Transactions::class);
    }
}
