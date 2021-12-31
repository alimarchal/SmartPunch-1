<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Business extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'company_name', 'country_name', 'company_logo', 'country_code', 'city_name', 'ibr'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function offices(): HasMany
    {
        return $this->hasMany(Office::class);
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }
}
