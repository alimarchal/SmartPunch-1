<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PunchTable extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['user_id', 'office_id', 'time','in_out_status'];

    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }
}
