<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    protected $table = 'registration';
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'ConfirmPassword',
        'role',
        'status',
    ];
    protected $hidden = [
        'password',
        'ConfirmPassword',
    ];
    
}
