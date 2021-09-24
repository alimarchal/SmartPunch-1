<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = ['type', 'start_time', 'end_time', 'break_start', 'break_end', 'status'];

    public function scheduleType(): HasOne
    {
        return $this->hasOne(ScheduleType::class,'id', 'type');
    }

    public function userSchedules(): HasMany
    {
        return $this->hasMany(UserHasSchedule::class,'user_id', 'id');
    }

}
