<?php

namespace App\Models;

use App\Builders\PermissionBuilder;
use App\Supports\Traits\OverridesBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Permission as BasePermission;

class Permission extends BasePermission {
    use HasFactory, OverridesBuilder;

    public function provideCustomBuilder() {
        return PermissionBuilder::class;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'guard_name', 'name', 'display_name'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        //
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        //
    ];
}
