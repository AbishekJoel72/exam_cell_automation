<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $table = 'departments';

    protected $fillable = [
        'department_name',
        'department_code',
        'status',
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

}
