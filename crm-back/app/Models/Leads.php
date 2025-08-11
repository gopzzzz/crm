<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leads extends Model
{
    use HasFactory;
    protected $fillable = [
        'lead_type',
        'full_name',
        'email',
        'phone_number',
        'checkin',
        'checkout',
        'numberofguest',
        'child',
        'infant',
        'room_type',
        'purpose',
        'reminder_date',
        'note',
        'assign_id',
        'status',
        'sale_status',
        'task_status',

    ];
}
