<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subjects extends Model
{
    protected $table = 'subjects';
    protected $fillable = [
        'department_id',
        'course_id',
        'semester',
        'subject_code',
        'subject_name',
        'credits',
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function get_department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }

    public function get_courses()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }

}
