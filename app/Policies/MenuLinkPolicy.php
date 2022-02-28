<?php

namespace App\Policies;

use App\Enums\PermissionType;
use App\Models\Menu;
use App\Models\MenuLink;
use App\Supports\Interfaces\AuthInterface;

class MenuLinkPolicy extends BasePolicy
{
    /**
     * @param AuthInterface $currentUser
     *
     * @return mixed
     */
    public function viewAny(AuthInterface $currentUser)
    {
        return $this->authorize($currentUser, PermissionType::VIEW_MENU);
    }

    /**
     * @param AuthInterface $currentUser
     *
     * @param MenuLink $menulink
     *
     * @return mixed
     */
    public function view(AuthInterface $currentUser, MenuLink $menulink)
    {
        return $this->authorize($currentUser, PermissionType::VIEW_MENU);
    }

    /**
     * @param AuthInterface $currentUser
     *
     * @return mixed
     */
    public function create(AuthInterface $currentUser)
    {
        return $this->authorize($currentUser, PermissionType::CREATE_MENU);
    }

    /**
     * @param AuthInterface $currentUser
     * @param \App\Models\MenuLink $menuLink
     * @return mixed
     */
    public function update(AuthInterface $currentUser, MenuLink $menuLink)
    {
        return $this->authorize($currentUser, PermissionType::UPDATE_MENU);
    }

    /**
     * @param \App\Supports\Interfaces\AuthInterface $currentUser
     * @param \App\Models\MenuLink $menuLink
     * @return mixed
     */
    public function delete(AuthInterface $currentUser, MenuLink $menuLink)
    {
        return $this->authorize($currentUser, PermissionType::DELETE_MENU);
    }
}
