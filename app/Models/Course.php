<?php

namespace App\Models;
use App\Models\Department;
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

   public function get_department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }
}
