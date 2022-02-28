<?php

namespace App\Models;

use App\Builders\AdminBuilder;
use App\Supports\Interfaces\AuthInterface;
use App\Supports\Traits\HasUuid;
use App\Supports\Traits\OverridesBuilder;
use App\Supports\Traits\UserStamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Admin extends Authenticatable implements JWTSubject, AuthInterface {
    use HasFactory, Notifiable, HasUuid, HasRoles, OverridesBuilder, UserStamps, SoftDeletes;

    protected $table = 'admins';

    public function isAdmin(): bool {
        return true;
    }

    public function provideCustomBuilder() {
        return AdminBuilder::class;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * @return mixed
     */
    public function getJWTIdentifier() {
        return $this->getKey();
    }

    /**
     * @return array
     */
    public function getJWTCustomClaims() {
        return [];
    }

    /**
     * @return mixed|string
     */
    public function getPasswordAttribute() {
        return $this->attributes['password'];
    }

    /**
     * @param $value
     */
    public function setPasswordAttribute($value) {
        $this->attributes['password'] = Hash::make($value);
    }
}
