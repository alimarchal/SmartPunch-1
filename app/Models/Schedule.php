<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = ['business_id','name', 'start_time', 'end_time', 'break_start', 'break_end', 'status'];

    public function userSchedules(): HasMany
    {
        return $this->hasMany(UserHasSchedule::class,'user_id', 'id');
    }

    public function business(): HasOne
    {
        return $this->hasOne(Business::class,'business_id', 'id');
    }

    public function officeSchedules(): HasMany
    {
        return $this->hasMany(OfficeSchedule::class, 'schedule_id', 'id');
    }

}
