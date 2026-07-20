<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Faculties extends Model
{
    protected $table = 'faculties';

    protected $fillable = [
        'department_id',
        'staff_code',
        'first_name',
        'last_name',
        'gender',
        'dob',
        'email',
        'phone',
        'designation',
        'qualification',
        'experience',
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
