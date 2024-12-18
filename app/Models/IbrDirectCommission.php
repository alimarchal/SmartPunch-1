<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class IbrDirectCommission extends Model
{
    use HasFactory;

    protected $fillable = [
        'ibr_no', 'transaction_id', 'amount', 'status'
    ];

    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class);
    }

    public function ibr(): BelongsTo
    {
        return $this->belongsTo(Ibr::class);
    }

    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class);
    }

    public function inDirectCommissions(): HasMany
    {
        return $this->hasMany(IbrIndirectCommission::class);
    }

}
