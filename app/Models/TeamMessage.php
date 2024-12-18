<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TeamMessage extends Model
{
    use HasFactory;

    protected $fillable = ['team_id', 'user_id_from', 'user_id_to', 'business_id', 'office_id', 'message', 'read_at'];

    public function userSend(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id_from', 'id');
    }

    public function userReceived(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id_to', 'id');
    }

    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class);
    }

    public function officeID(): BelongsTo
    {
        return $this->belongsTo(Office::class);
    }


    protected $appends = ['user'];


    public function getUserAttribute()
    {
        return User::find($this->user_id_from);
    }
}
