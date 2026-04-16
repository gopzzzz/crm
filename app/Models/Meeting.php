<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    use HasFactory;
 protected $fillable = [
        'title',
        'description',
        'link',
        'meeting_date',
        'meeting_time',
        'assigned_staff',
        'status'
    ];
    
}
