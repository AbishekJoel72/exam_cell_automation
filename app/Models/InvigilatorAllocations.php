<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvigilatorAllocations extends Model
{
    protected $table = "invigilator_allocations";
    protected $fillable = [
        'exam_id',
        'staff_id',
        'classroom_id',
    ];
}
