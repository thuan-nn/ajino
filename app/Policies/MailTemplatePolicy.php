<?php

namespace App\Policies;

use App\Enums\PermissionType;
use App\Models\MailTemplate;
use App\Supports\Interfaces\AuthInterface;

class MailTemplatePolicy extends BasePolicy
{
    /**
     * @param AuthInterface $currentUser
     *
     * @return mixed
     */
    public function viewAny(AuthInterface $currentUser)
    {
        return $this->authorize($currentUser, PermissionType::VIEW_MAIL_TEMPLATE);
    }

    /**
     * @param AuthInterface $currentUser
     *
     * @return mixed
     */
    public function view(AuthInterface $currentUser)
    {
        return $this->authorize($currentUser, PermissionType::VIEW_MAIL_TEMPLATE);
    }

    /**
     * @param AuthInterface $currentUser
     *
     * @return mixed
     */
    public function create(AuthInterface $currentUser)
    {
        return $this->authorize($currentUser, PermissionType::CREATE_MAIL_TEMPLATE);
    }

    /**
     * @param AuthInterface $currentUser
     * @param \App\Models\MailTemplate $mailTemplate
     * @return mixed
     */
    public function update(AuthInterface $currentUser, MailTemplate $mailTemplate)
    {
        return $this->authorize($currentUser, PermissionType::UPDATE_MAIL_TEMPLATE);
    }

    /**
     * @param AuthInterface $currentUser
     * @param \App\Models\MailTemplate $mailTemplate
     * @return mixed
     */
    public function delete(AuthInterface $currentUser, MailTemplate $mailTemplate)
    {
        return $this->authorize($currentUser, PermissionType::DELETE_MAIL_TEMPLATE);
    }
}
