<?php

namespace App\Policies;

use App\Enums\PermissionType;
use App\Models\CompanyTour;
use App\Models\Visitor;
use App\Models\VisitorFileSetting;
use App\Supports\Interfaces\AuthInterface;

class VisitorFileSettingPolicy extends BasePolicy
{
    /**
     * @param AuthInterface $currentUser
     *
     * @return mixed
     */
    public function viewAny(AuthInterface $currentUser)
    {
        return $this->authorize($currentUser, PermissionType::VIEW_COMPANY_TOUR);
    }

    /**
     * @param AuthInterface $currentUser
     *
     * @return mixed
     */
    public function view(AuthInterface $currentUser)
    {
        return $this->authorize($currentUser, PermissionType::VIEW_COMPANY_TOUR);
    }

    /**
     * @param AuthInterface $currentUser
     *
     * @return mixed
     */
    public function create(AuthInterface $currentUser)
    {
        return $this->authorize($currentUser, PermissionType::CREATE_COMPANY_TOUR);
    }

    /**
     * @param AuthInterface $currentUser
     * @param \App\Models\VisitorFileSetting $visitorFileSetting
     * @return mixed
     */
    public function update(AuthInterface $currentUser, VisitorFileSetting $visitorFileSetting)
    {
        return $this->authorize($currentUser, PermissionType::UPDATE_COMPANY_TOUR);
    }

    /**
     * @param AuthInterface $currentUser
     * @param \App\Models\VisitorFileSetting $visitorFileSetting
     * @return mixed
     */
    public function delete(AuthInterface $currentUser, VisitorFileSetting $visitorFileSetting)
    {
        return $this->authorize($currentUser, PermissionType::DELETE_COMPANY_TOUR);
    }
}
