<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Package extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'users', 'monthly', 'quarterly', 'half_year', 'yearly', 'popular', 'status'];

    public function businessPackage(): HasMany
    {
        return $this->hasMany(BusinessPackages::class);
    }
}
