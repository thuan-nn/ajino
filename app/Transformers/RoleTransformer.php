<?php

namespace App\Transformers;

use App\Models\Role;
use Flugg\Responder\Transformers\Transformer;

class RoleTransformer extends Transformer {
    /**
     * List of available relations.
     *
     * @var string[]
     */
    protected $relations = [
        'admins'      => AdminTransformer::class,
        'permissions' => PermissionTransformer::class
    ];

    /**
     * List of autoloaded default relations.
     *
     * @var array
     */
    protected $load = [];

    /**
     * Transform the model.
     *
     * @param \App\Models\Role $role
     *
     * @return array
     */
    public function transform(Role $role) {
        return [
            'id'           => (int)$role->id,
            'name'         => (string)$role->name,
            'guard_name'   => (string)$role->guard_name,
            'display_name' => (string)$role->display_name,
            'created_at'   => (string)$role->created_at,
            'updated_at'   => (string)$role->updated_at
        ];
    }
}
