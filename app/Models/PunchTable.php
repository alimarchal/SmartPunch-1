<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PunchTable extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['user_id', 'office_id', 'time', 'in_out_status'];

    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function offices(): BelongsTo
    {
        return $this->belongsTo(Office::class,'office_id','id');
    }
}
