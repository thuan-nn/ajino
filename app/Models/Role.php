<?php

namespace App\Models;

use App\Builders\RoleBuilder;
use App\Supports\Traits\OverridesBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Permission\Models\Role as BaseRole;

class Role extends BaseRole
{
    use HasFactory, OverridesBuilder;

    public function provideCustomBuilder()
    {
        return RoleBuilder::class;
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

    public function admins(): BelongsToMany
    {
        return $this->belongsToMany(Admin::class, 'model_has_roles', 'role_id', 'model_uuid');
    }
}
