<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tasks extends Model
{
    use HasFactory;
    protected $fillable = [
        'lead_id',
        'due_date',
        'start_date',
        'task_created_date',
        'notes',
        'assign_id',
        'status',
        'priority',

    ];
}
