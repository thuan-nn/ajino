<?php

namespace App\Policies;

use App\Enums\PermissionType;
use App\Models\Contact;
use App\Supports\Interfaces\AuthInterface;

class ContactPolicy extends BasePolicy
{
    /**
     * @param AuthInterface $currentUser
     *
     * @return mixed
     */
    public function viewAny(AuthInterface $currentUser)
    {
        return $this->authorize($currentUser, PermissionType::VIEW_CONTACT);
    }

    /**
     * @param AuthInterface $currentUser
     *
     * @return mixed
     */
    public function view(AuthInterface $currentUser)
    {
        return $this->authorize($currentUser, PermissionType::VIEW_CONTACT);
    }

    /**
     * @param AuthInterface $currentUser
     *
     * @return mixed
     */
    public function create(AuthInterface $currentUser)
    {
        return $this->authorize($currentUser, PermissionType::CREATE_CONTACT);
    }

    /**
     * @param AuthInterface $currentUser
     * @param \App\Models\Contact $contact
     * @return mixed
     */
    public function update(AuthInterface $currentUser, Contact $contact)
    {
        return $this->authorize($currentUser, PermissionType::UPDATE_CONTACT);
    }

    /**
     * @param AuthInterface $currentUser
     * @param \App\Models\Contact $contact
     * @return mixed
     */
    public function delete(AuthInterface $currentUser, Contact $contact)
    {
        return $this->authorize($currentUser, PermissionType::DELETE_CONTACT);
    }
}
