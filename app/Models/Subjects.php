<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subjects extends Model
{
    protected $table = 'subjects';
    protected $fillable = [
        'department_id',
        'semester',
        'subject_code',
        'subject_name',
        'credits',
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
    
}
