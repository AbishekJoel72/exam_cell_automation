<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    protected $table = 'classrooms';
    protected $fillable = [
        'room_no',
        'building',
        'floor',
        'total_seats',
        'status',
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
