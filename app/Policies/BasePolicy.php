<?php

namespace App\Policies;

use App\Enums\UserType;
use App\Supports\Interfaces\AuthInterface;
use Illuminate\Auth\Access\HandlesAuthorization;

class BasePolicy
{
    use HandlesAuthorization;

    /**
     * @param \App\Supports\Interfaces\AuthInterface $user
     * @param $permission
     * @return mixed
     */
    public function authorize(AuthInterface $user, $permission)
    {
        if (is_string($permission)) {
            $permission = [$permission];
        }

        return $user->hasAnyPermission(
            $permission,
            $user->isAdmin() ? 'admins' : null
        );
    }
}
