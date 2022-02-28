<?php

namespace App\Policies;

use App\Enums\PermissionType;
use App\Models\CompanyTour;
use App\Models\Visitor;
use App\Supports\Interfaces\AuthInterface;

class VisitorPolicy extends BasePolicy
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
     * @param \App\Models\Visitor $visitor
     * @return mixed
     */
    public function update(AuthInterface $currentUser, Visitor $visitor)
    {
        return $this->authorize($currentUser, PermissionType::UPDATE_COMPANY_TOUR);
    }

    /**
     * @param AuthInterface $currentUser
     * @param \App\Models\Visitor $visitor
     * @return mixed
     */
    public function delete(AuthInterface $currentUser, Visitor $visitor)
    {
        return $this->authorize($currentUser, PermissionType::DELETE_COMPANY_TOUR);
    }
}
