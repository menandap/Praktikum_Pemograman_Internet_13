<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Responses extends Model
{
    use HasFactory;
    protected $table = "responses";
    protected $fillable = [
        'review_id',
        'admin_id',
        'content'
    ];

    public function admins() { 
        return $this->belongsTo(Admin::class);
    }
}
