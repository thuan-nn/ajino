<?php

namespace App\Policies;

use App\Enums\PermissionType;
use App\Models\Banner;
use App\Supports\Interfaces\AuthInterface;

class BannerPolicy extends BasePolicy
{
    /**
     * @param AuthInterface $currentUser
     *
     * @return mixed
     */
    public function viewAny(AuthInterface $currentUser)
    {
        return $this->authorize($currentUser, PermissionType::VIEW_BANNER);
    }

    /**
     * @param AuthInterface $currentUser
     *
     * @param \App\Models\Banner $banner
     * @return mixed
     */
    public function view(AuthInterface $currentUser, Banner $banner)
    {
        return $this->authorize($currentUser, PermissionType::VIEW_BANNER);
    }

    /**
     * @param AuthInterface $currentUser
     *
     * @return mixed
     */
    public function create(AuthInterface $currentUser)
    {
        return $this->authorize($currentUser, PermissionType::CREATE_BANNER);
    }

    /**
     * @param AuthInterface $currentUser
     * @param \App\Models\Banner $banner
     * @return mixed
     */
    public function update(AuthInterface $currentUser, Banner $banner)
    {
        return $this->authorize($currentUser, PermissionType::UPDATE_BANNER);
    }

    /**
     * @param AuthInterface $currentUser
     * @param \App\Models\Banner $banner
     * @return mixed
     */
    public function delete(AuthInterface $currentUser, Banner $banner)
    {
        return $this->authorize($currentUser, PermissionType::DELETE_BANNER);
    }
}
