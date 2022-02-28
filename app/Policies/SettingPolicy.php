<?php

namespace App\Policies;

use App\Enums\PermissionType;
use App\Models\Setting;
use App\Supports\Interfaces\AuthInterface;

class SettingPolicy extends BasePolicy
{
    /**
     * @param AuthInterface $currentUser
     *
     * @return mixed
     */
    public function viewAny(AuthInterface $currentUser)
    {
        return $this->authorize($currentUser, PermissionType::VIEW_SETTING);
    }

    /**
     * @param AuthInterface $currentUser
     *
     * @return mixed
     * @throws \Exception
     */
    public function view(AuthInterface $currentUser)
    {
        return $this->authorize($currentUser, PermissionType::VIEW_SETTING);
    }

    /**
     * @param AuthInterface $currentUser
     *
     * @return mixed
     * @throws \Exception
     */
    public function create(AuthInterface $currentUser)
    {
        return $this->authorize($currentUser, PermissionType::CREATE_SETTING);
    }

    /**
     * @param \App\Supports\Interfaces\AuthInterface $currentUser
     * @param \App\Models\Setting $setting
     * @return mixedd
     */
    public function update(AuthInterface $currentUser, Setting $setting)
    {
        return $this->authorize($currentUser, PermissionType::UPDATE_SETTING);
    }

    /**
     * @param \App\Supports\Interfaces\AuthInterface $currentUser
     * @param \App\Models\Setting $setting
     * @return mixed
     */
    public function delete(AuthInterface $currentUser, Setting $setting)
    {
        return $this->authorize($currentUser, PermissionType::DELETE_SETTING);
    }
}
