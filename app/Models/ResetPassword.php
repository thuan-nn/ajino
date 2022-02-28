<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResetPassword extends Model {
    protected $table = 'password_resets';

    public $timestamps = false;

    protected $fillable = [
        'email', 'token', 'expired_at'
    ];
}
