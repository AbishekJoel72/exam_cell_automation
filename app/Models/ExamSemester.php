<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamSemester extends Model
{
    protected $table = "exam_semesters";
    protected $fillable = [
        'exam_id',
        'semester',
    ];
     protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
