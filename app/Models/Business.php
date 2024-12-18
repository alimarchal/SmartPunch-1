<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Business extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'company_name', 'country_name', 'company_logo', 'country_code', 'city_name', 'ibr'];

    protected function countryName(): Attribute
    {
        return new Attribute(
            get: fn($value) => Country::where('id', $value)->first(['id', 'name'])
        );
    }

    protected function cityName(): Attribute
    {
        return new Attribute(
            get: fn($value) => City::where('id', $value)->first(['id', 'name'])
        );
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function activeUsers(): HasMany
    {
        return $this->hasMany(User::class)->where('status',1)->where('user_role', '!=','2');
    }

    public function offices(): HasMany
    {
        return $this->hasMany(Office::class);
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }

    public function businessPackages(): HasOne
    {
        return $this->hasOne(BusinessPackages::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function coupon(): HasMany
    {
        return $this->hasMany(Coupon::class);
    }

    public function directCommissions(): HasOne
    {
        return $this->hasOne(IbrDirectCommission::class);
    }

    public function ibr(): HasOne
    {
        return $this->hasOne(Ibr::class,'ibr_no','ibr');
    }

}
