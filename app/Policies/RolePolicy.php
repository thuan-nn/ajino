<?php

namespace App\Policies;

use App\Enums\PermissionType;
use App\Models\Admin;
use App\Models\Role;
use App\Supports\Interfaces\AuthInterface;

class RolePolicy extends BasePolicy {
    /**
     * @param AuthInterface $currentUser
     *
     * @return mixed
     */
    public function viewAny(AuthInterface $currentUser) {
        return $this->authorize($currentUser, PermissionType::VIEW_ROLE);
    }

    /**
     * @param AuthInterface $currentUser
     *
     * @return mixed
     * @throws \Exception
     */
    public function view(AuthInterface $currentUser) {
        return $this->authorize($currentUser, PermissionType::VIEW_ROLE);
    }

    /**
     * @param AuthInterface $currentUser
     *
     * @return mixed
     * @throws \Exception
     */
    public function create(AuthInterface $currentUser) {
        return $this->authorize($currentUser, PermissionType::CREATE_ROLE);
    }

    /**
     * @param AuthInterface $currentUser
     * @param \App\Models\Role $role
     * @return mixed
     */
    public function update(AuthInterface $currentUser, Role $role) {
        return $this->authorize($currentUser, PermissionType::UPDATE_ROLE);
    }

    /**
     * @param AuthInterface $currentUser
     * @param \App\Models\Role $role
     * @return mixed
     */
    public function delete(AuthInterface $currentUser, Role $role) {
        return $this->authorize($currentUser, PermissionType::DELETE_ROLE);
    }
}
