<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tbl_employees extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'designation',
        'phone_number',
        'address',
        'dob',
        'userid',
        'status',
    ];


}
