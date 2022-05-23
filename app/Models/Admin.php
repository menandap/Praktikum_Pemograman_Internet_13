<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Schema;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Admin extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    use HasFactory;
    protected $table = "admins";
    protected $fillable = [
        'username',
        'password',
        'name',
        'profile_image',
        'phone',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function down()
    {
        Schema::dropIfExists('admins');
    }

    
    public function admin_notifications() {
    return $this->hasMany(Admin_notifications::class);
    }

    public function response() {
    return $this->hasMany(Responses::class);
    }

    public function createNotif($data)
    {
        $notif = new Admin_notifications();
        $notif->type = 'App\Notifications\ProducNotification';
        $notif->notifiable_type = 'App\Models\Admin';
        $notif->notifiable_id = $this->id;
        $notif->data = $data;
        $notif->read_at = null;
        $notif->save();
    }

}
