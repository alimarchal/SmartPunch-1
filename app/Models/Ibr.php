<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Ibr extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $guarded = ['id'];
    protected $fillable = ['ibr_no', 'referred_by', 'name', 'email', 'email_verified_at', 'verify_token', 'verified', 'otp', 'password', 'gender', 'country_of_business', 'country_of_bank', 'bank', 'iban', 'currency', 'mobile_number', 'dob', 'mac_address', 'device_name', 'rtl', 'status'];

    protected $hidden = [
        'password',
        'remember_token'
    ];
}
