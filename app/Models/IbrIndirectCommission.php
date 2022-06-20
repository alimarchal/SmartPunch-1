<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IbrIndirectCommission extends Model
{
    use HasFactory;

    protected $fillable = [
        'ibr_no', 'referred_by', 'ibr_direct_commission_id', 'amount', 'status'
    ];

    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class);
    }

    public function ibr(): BelongsTo
    {
        return $this->belongsTo(Ibr::class);
    }

    public function directCommission(): BelongsTo
    {
        return $this->belongsTo(IbrDirectCommission::class,'ibr_direct_commission_id', 'id');
    }
}
