<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    protected $table = 'registration';
    protected $fillable = [
        'username',
        'name',
        'email',
        'phone',
        'password',
        'role',
        'status',
    ];
    protected $hidden = [
        'password',
    ];

}
