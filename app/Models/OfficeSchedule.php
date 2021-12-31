<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class OfficeSchedule extends Model
{
    use HasFactory;

    public $timestamps = false;

    public $fillable = ['office_id', 'schedule_id'];

    public function office(): HasOne
    {
        return $this->hasOne(Office::class, 'id', 'office_id');
    }

    public function schedule(): HasOne
    {
        return $this->hasOne(Schedule::class, 'id', 'schedule_id');
    }
}
