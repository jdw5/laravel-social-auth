<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSocial extends Model
{
    use HasFactory;

    protected $table = 'users_socials';

    protected $fillable = [
        'social_id', 
        'service'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
