<?php

namespace App\Policies;

use App\Enums\PermissionType;
use App\Models\Admin;
use App\Models\Menu;
use App\Supports\Interfaces\AuthInterface;

class MenuPolicy extends BasePolicy {
    /**
     * @param AuthInterface $currentUser
     *
     * @return mixed
     */
    public function viewAny(AuthInterface $currentUser) {
        return $this->authorize($currentUser, PermissionType::VIEW_MENU);
    }

    /**
     * @param AuthInterface $currentUser
     *
     * @return mixed
     */
    public function view(AuthInterface $currentUser) {
        return $this->authorize($currentUser, PermissionType::VIEW_MENU);
    }

    /**
     * @param AuthInterface $currentUser
     *
     * @return mixed
     */
    public function create(AuthInterface $currentUser) {
        return $this->authorize($currentUser, PermissionType::CREATE_MENU);
    }

    /**
     * @param AuthInterface $currentUser
     * @param \App\Models\Menu $menu
     * @return mixed
     */
    public function update(AuthInterface $currentUser, Menu $menu) {
        return $this->authorize($currentUser, PermissionType::UPDATE_MENU);
    }

    /**
     * @param AuthInterface $currentUser
     * @param \App\Models\Menu $menu
     * @return mixed
     */
    public function delete(AuthInterface $currentUser, Menu $menu) {
        return $this->authorize($currentUser, PermissionType::DELETE_MENU);
    }
}
