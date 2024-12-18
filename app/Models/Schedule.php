<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = ['business_id','name', 'start_time', 'end_time', 'break_start', 'break_end', 'status'];

    protected function startTime(): Attribute
    {
        return new Attribute(
            get: fn($value) => Carbon::parse($value)->format('g:i A'),
            set: fn($value) => Carbon::parse($value)->format('H:i:s'),
        );
    }
    protected function endTime(): Attribute
    {
        return new Attribute(
            get: fn($value) => Carbon::parse($value)->format('g:i A'),
            set: fn($value) => Carbon::parse($value)->format('H:i:s'),
        );
    }
    protected function breakStart(): Attribute
    {
        return new Attribute(
            get: fn($value) => Carbon::parse($value)->format('g:i A'),
            set: fn($value) => Carbon::parse($value)->format('H:i:s'),
        );
    }
    protected function breakEnd(): Attribute
    {
        return new Attribute(
            get: fn($value) => Carbon::parse($value)->format('g:i A'),
            set: fn($value) => Carbon::parse($value)->format('H:i:s'),
        );
    }
    protected function status(): Attribute
    {
        return new Attribute(
            get: fn($value) => $value == 1 ? __('portal.Approved') : __('portal.Pending'),
        );
    }

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
