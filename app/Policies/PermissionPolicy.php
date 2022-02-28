<?php

namespace App\Policies;

use App\Enums\PermissionType;
use App\Models\Permission;
use App\Supports\Interfaces\AuthInterface;

class PermissionPolicy extends BasePolicy {
    public function viewAny(AuthInterface $user) {
        return $this->authorize($user, PermissionType::VIEW_ROLE);
    }

    public function view(AuthInterface $user, Permission $permission) {
        return $this->authorize($user, PermissionType::VIEW_ROLE);
    }
}
