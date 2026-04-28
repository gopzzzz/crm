<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;
    protected $table = 'attendances';

    protected $fillable = [
        'user_id',
        'date',
        'punch_in',
        'punch_out',
        'punch_in_note',
        'punch_out_note',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
