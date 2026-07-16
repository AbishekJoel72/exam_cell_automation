<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $table = 'courses';

    protected $fillable = [
        'department_id',
        'course_name',
        'course_code',
        'duration',
        'status',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
