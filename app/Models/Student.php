<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $table = 'students';

    protected $fillable = [
        'department_id',
        'course_id',
        'classroom_id',
        'first_name',
        'last_name',
        'gender',
        'dob',
        'email',
        'phone',
        'register_no',
        'roll_no',
        'academic_year',
        'current_year',
        'semester',
        'section',
        'status',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function get_department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }

    public function get_course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }

    public function get_classroom()
    {
        return $this->belongsTo(Classroom::class, 'classroom_id', 'id');
    }
}
