<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class UserHasSchedule extends Model
{
    use HasFactory;

    protected $fillable = ['schedule_id', 'user_id'];

    public function schedule(): HasOne
    {
        return $this->hasOne(Schedule::class, 'id', 'schedule_id');
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
