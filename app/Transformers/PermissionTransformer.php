<?php

namespace App\Transformers;


use App\Models\Permission;
use Flugg\Responder\Transformers\Transformer;

class PermissionTransformer extends Transformer {
    /**
     * List of available relations.
     *
     * @var string[]
     */
    protected $relations = [
        'roles' => RoleTransformer::class
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
     * @param \App\Permission $permission
     *
     * @return array
     */
    public function transform(Permission $permission) {
        return [
            'id'           => (string)$permission->id,
            'name'         => (string)$permission->name,
            'guard_name'   => (string)$permission->guard_name,
            'display_name' => (string)$permission->display_name,
            'created_at'   => (string)$permission->created_at,
            'updated_at'   => (string)$permission->updated_at
        ];
    }
}
