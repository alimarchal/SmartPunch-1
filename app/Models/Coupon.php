<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_id', 'name', 'code', 'amount_type', 'amount', 'valid_from', 'valid_to', 'country', 'consume_status', 'status'
    ];

    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class);
    }
}
