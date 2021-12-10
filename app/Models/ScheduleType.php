<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ScheduleType extends Model
{
    use HasFactory;

    protected $fillable = ['name','business_id','office_id'];

    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class,'type','id');
    }
}
