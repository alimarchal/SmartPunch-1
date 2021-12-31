<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Office extends Model
{
    use HasFactory;

    protected $fillable = ['business_id','name','email','address','city','coordinates','phone','country'];

    public function business(): HasOne
    {
        return $this->hasOne(Business::class, 'id', 'business_id');
    }

    public function employees(): HasMany
    {
        return $this->hasMany(User::class, 'office_id', 'id');
    }

    public function officeSchedules(): HasMany
    {
        return $this->hasMany(OfficeSchedule::class, 'office_id', 'id');
    }
}
