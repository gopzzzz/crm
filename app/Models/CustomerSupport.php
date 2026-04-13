<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerSupport extends Model
{
    use HasFactory;
    protected $table = 'customer_supports';

    protected $fillable = [
        'customer_name',
        'issue',
        'status',
        'assigned_employee'
    ];
}
