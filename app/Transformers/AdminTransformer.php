<?php

namespace App\Transformers;

use App\Models\Admin;
use Flugg\Responder\Transformers\Transformer;

class AdminTransformer extends Transformer {
    /**
     * List of available relations.
     *
     * @var string[]
     */
    protected $relations = [
        'roles'       => RoleTransformer::class,
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
     * @param Admin $admin
     *
     * @return array
     */
    public function transform(Admin $admin) {
        return [
            'id'         => (string)$admin->id,
            'name'       => $admin->name,
            'email'      => $admin->email,
            'created_at' => (string)$admin->created_at,
            'updated_at' => (string)$admin->updated_at
        ];
    }

    /**
     * @param Admin $admin
     *
     * @return mixed
     */
    public function includePermissions(Admin $admin) {
        return $this->collection($admin->getAllPermissions(), new PermissionTransformer());
    }
}
