<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerSupportt extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_name',
        'issue',
    ];
}

