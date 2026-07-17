<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PasswordResetLog extends Model
{
    protected $table = 'password_resets_log';
    protected $fillable = [
        'user_id',
        'sent_via',
        'sent_to',
        'otp_code',
        'is_used',
        'expires_at',
    ];
    protected $casts = [
        'expires_at' => 'datetime',
    ];
    protected $hidden = [
        'otp_code',
    ];
    protected $with = [
        'user',
    ];
    public function get_user()
    {
        return $this->belongsTo(Registration::class, 'user_id');
    }
}
