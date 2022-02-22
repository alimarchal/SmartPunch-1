<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_id', 'package_id', 'package_type', 'card_number', 'cvv', 'card_valid_from', 'card_valid_to', 'amount', 'bank_name', 'status'
    ];

    public function business(): HasOne
    {
        return $this->hasOne(Business::class);
    }

    public function packages(): BelongsTo
    {
        return $this->belongsTo(Package::class);
//        return $this->belongsTo(Package::class,'package_id','id');
    }

    public function businessPackage(): BelongsTo
    {
        return $this->belongsTo(BusinessPackages::class);
//        return $this->belongsTo(BusinessPackages::class,'id','transaction_id');
    }

    public function directCommissions(): HasOne
    {
        return $this->hasOne(IbrDirectCommission::class);
    }
}
