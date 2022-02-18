<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class BusinessPackages extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_id', 'transaction_id', 'package_id', 'package_type', 'package_amount', 'start_date', 'end_date', 'status'
    ];

    public function business(): HasOne
    {
        return $this->hasOne(Business::class);
    }

    public function package(): HasOne
    {
        return $this->hasOne(Package::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
//        return $this->hasMany(Transaction::class,'id','transaction_id');
    }

}
