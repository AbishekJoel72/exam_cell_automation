<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeatAllocations extends Model
{
    protected $table = "seat_allocations";
    protected $fillable = [
        'exam_id',
        'student_id',
        'classroom_id',
        'seat_no',
        'row_no',

    ];
}
