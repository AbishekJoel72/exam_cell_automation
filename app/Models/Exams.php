<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exams extends Model
{
    protected $table = "exams";
    protected $fillable = [
        'department_id',
        'exam_name',
        'exam_type',
        'exam_cycle',
        'exam_date',
        'start_time',
        'end_time',
        'status',

    ];
}
