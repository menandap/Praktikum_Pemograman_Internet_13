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

    public function user_notification()
    {
        return $this->hasMany(User_notifications::class, "notifiable_id");
    }

    public function transaction()
    {
        return $this->hasMany(Transactions::class, "user_id");
    }

    public function cart()
    {
        return $this->hasMany(Carts::class, "user_id");
    }

    public function product_review()
    {
        return $this->hasMany(Product_reviews::class, "user_id");
    }
}
