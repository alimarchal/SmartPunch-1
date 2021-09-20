<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Office extends Model
{
    use HasFactory;

    protected $fillable = ['business_id','name','email','address','city','coordinates','phone'];

    public function business(): HasOne
    {
        return $this->hasOne(Business::class);
    }
}
