<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    //hard coded user type
    const USER_TYPE = [
        'admin' => 'admin',
        'student' => 'student',
        'teacher' => 'teacher',
    ];
    //hard coded currency
    const CURRENCY = [
        'usd' => 'USD',
        'eur' => 'EUR',
        'gbp' => 'GBP',
        'nzd' => 'NZD',
        'cad' => 'CAD',
    ];

   protected $fillable = ['user_name', 'email', 'password','user_type','whatsapp_number','hour_price','currency'];
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
