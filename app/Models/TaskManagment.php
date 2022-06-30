<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskManagment extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_name',
        'task_progress',
        'business_id',
        'office_id',
        'start_date',
        'end_date',
        'assign_to',
        'assign_from',
        'comment',
    ];
}
