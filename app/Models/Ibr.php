<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Ibr extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $guarded = ['id'];
    protected $fillable = [
        'ibr_no', 'referred_by', 'name', 'email', 'email_verified_at', 'verify_token', 'verified', 'otp',
        'password', 'gender', 'country_of_business', 'city_of_business', 'country_of_bank', 'bank', 'iban', 'currency',
        'mobile_number', 'dob', 'mac_address', 'device_name', 'rtl', 'status'
    ];

    protected $hidden = [
        'password',
        'remember_token'
    ];

    /* Accessor for displaying country name */
    protected function countryOfBusiness(): Attribute
    {
        return new Attribute(
            get: fn($value) => Country::where('id', $value)
                ->select('name')
                ->value('name')
        );
    }

    /* Relation for IBRs having child IBRs start */
    public function ibr(): HasMany
    {
        // This relationship will only return one level of child items
        return $this->hasMany(Ibr::class,'referred_by','ibr_no');
    }

    public function ibrReferred(): HasMany
    {
        // This is method where we implement recursive relationship
        return $this->hasMany(Ibr::class,'referred_by', 'ibr_no')->with('ibr');
    }
    /* Relation for IBRs having child IBRs end */

    /* Relation for IBRs having parent IBRs start */
    public function parentIbr(): HasMany
    {
        // This relationship will only return one level of parent ibr
        return $this->hasMany(Ibr::class,'ibr_no','referred_by')->select('id','ibr_no','referred_by');
    }

    public function parentIbrReference(): HasMany
    {
        // This is method where we implement recursive relationship
        return $this->hasMany(Ibr::class,'ibr_no', 'referred_by')->with('parentIbr');
    }
    /* Relation for IBRs having parent IBRs end */

    public function directCommissions(): HasMany
    {
        return $this->hasMany(IbrDirectCommission::class);
    }

    public function indirectCommissions(): HasMany
    {
        return $this->hasMany(IbrIndirectCommission::class);
    }
}
