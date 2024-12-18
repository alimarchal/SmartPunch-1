<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserOffice extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'office_id', 'previous_office_id', 'status'];

    public function office(): BelongsTo
    {
        return $this->belongsTo(Office::class, 'office_id','id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
}
