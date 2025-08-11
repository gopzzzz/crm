<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agents extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'phone_number', 'district_id', 'address', 'adhar_number', 
        'account_number', 'ifsc', 'branch_name', 'user_id'
    ];
}
