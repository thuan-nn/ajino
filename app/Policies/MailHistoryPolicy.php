<?php

namespace App\Policies;

use App\Enums\PermissionType;
use App\Models\MailHistory;
use App\Supports\Interfaces\AuthInterface;

class MailHistoryPolicy extends BasePolicy
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
     * @param \App\Models\MailHistory $mailHistory
     * @return mixed
     */
    public function update(AuthInterface $currentUser, MailHistory $mailHistory)
    {
        return $this->authorize($currentUser, PermissionType::UPDATE_COMPANY_TOUR);
    }

    /**
     * @param AuthInterface $currentUser
     * @param \App\Models\MailHistory $mailHistory
     * @return mixed
     */
    public function delete(AuthInterface $currentUser, MailHistory $mailHistory)
    {
        return $this->authorize($currentUser, PermissionType::DELETE_COMPANY_TOUR);
    }
}
