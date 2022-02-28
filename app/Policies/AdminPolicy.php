<?php

namespace App\Policies;

use App\Enums\PermissionType;
use App\Models\Admin;
use App\Supports\Interfaces\AuthInterface;

class AdminPolicy extends BasePolicy {
    /**
     * @param AuthInterface $currentUser
     *
     * @return mixed
     */
    public function viewAny(AuthInterface $currentUser) {
        return $this->authorize($currentUser, PermissionType::VIEW_ADMIN);
    }

    /**
     * @param AuthInterface $currentUser
     *
     * @return mixed
     * @throws \Exception
     */
    public function view(AuthInterface $currentUser) {
        return $this->authorize($currentUser, PermissionType::VIEW_ADMIN);
    }

    /**
     * @param AuthInterface $currentUser
     *
     * @return mixed
     * @throws \Exception
     */
    public function create(AuthInterface $currentUser) {
        return $this->authorize($currentUser, PermissionType::CREATE_ADMIN);
    }

    /**
     * @param AuthInterface $currentUser
     * @param Admin         $admin
     *
     * @return mixed
     */
    public function update(AuthInterface $currentUser, Admin $admin) {
        return $this->authorize($currentUser, PermissionType::UPDATE_ADMIN);
    }

    /**
     * @param AuthInterface $currentUser
     * @param Admin         $admin
     *
     * @return mixed
     */
    public function delete(AuthInterface $currentUser, Admin $admin) {
        return $this->authorize($currentUser, PermissionType::DELETE_ADMIN);
    }
}
