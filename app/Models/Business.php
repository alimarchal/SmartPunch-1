<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    use HasFactory;

    protected $fillable = ['company_name', 'country_name', 'country_code', 'city_name', 'company_logo', 'ibr'];
}
