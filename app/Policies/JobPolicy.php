<?php

namespace App\Policies;

use App\Enums\PermissionType;
use App\Models\Job;
use App\Supports\Interfaces\AuthInterface;

class JobPolicy extends BasePolicy
{
    /**
     * @param AuthInterface $currentUser
     *
     * @return mixed
     */
    public function viewAny(AuthInterface $currentUser)
    {
        return $this->authorize($currentUser, PermissionType::VIEW_CAREER);
    }

    /**
     * @param AuthInterface $currentUser
     *
     * @param \App\Models\Job $job
     * @return mixed
     */
    public function view(AuthInterface $currentUser, Job $job)
    {
        return $this->authorize($currentUser, PermissionType::VIEW_CAREER);
    }

    /**
     * @param AuthInterface $currentUser
     *
     * @return mixed
     */
    public function create(AuthInterface $currentUser)
    {
        return $this->authorize($currentUser, PermissionType::CREATE_CAREER);
    }

    /**
     * @param AuthInterface $currentUser
     * @param \App\Models\Job $job
     * @return mixed
     */
    public function update(AuthInterface $currentUser, Job $job)
    {
        return $this->authorize($currentUser, PermissionType::UPDATE_CAREER);
    }

    /**
     * @param AuthInterface $currentUser
     * @param \App\Models\Job $job
     * @return mixed
     */
    public function delete(AuthInterface $currentUser, Job $job)
    {
        return $this->authorize($currentUser, PermissionType::DELETE_CAREER);
    }
}
