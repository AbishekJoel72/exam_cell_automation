<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamSubject extends Model
{
    protected $table ="exam_subjects";
    protected $fillable = [
        'exam_id',
        'subject_id',
    ];
     protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
