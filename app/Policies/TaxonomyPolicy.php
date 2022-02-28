<?php

namespace App\Policies;

use App\Enums\PermissionType;
use App\Enums\TaxonomyEnum;
use App\Models\Taxonomy;
use App\Supports\Interfaces\AuthInterface;
use Illuminate\Support\Arr;

class TaxonomyPolicy extends BasePolicy
{
    /**
     * @param AuthInterface $currentUser
     *
     * @return mixed
     */
    public function viewAny(AuthInterface $currentUser)
    {
        $type = Arr::get(request('filters'), 'type');
        if ($type === TaxonomyEnum::CATEGORY) {
            return $this->authorize($currentUser, PermissionType::VIEW_CATEGORY);
        }

        return $this->authorize($currentUser, PermissionType::VIEW_TAG);
    }

    /**
     * @param AuthInterface $currentUser
     *
     * @return mixed
     * @throws \Exception
     */
    public function view(AuthInterface $currentUser)
    {
        if (request('type') === TaxonomyEnum::CATEGORY) {
            return $this->authorize($currentUser, PermissionType::VIEW_CATEGORY);
        }

        return $this->authorize($currentUser, PermissionType::VIEW_TAG);
    }

    /**
     * @param AuthInterface $currentUser
     *
     * @return mixed
     * @throws \Exception
     */
    public function create(AuthInterface $currentUser)
    {
        if (request('type') === TaxonomyEnum::CATEGORY) {
            return $this->authorize($currentUser, PermissionType::CREATE_CATEGORY);
        }

        return $this->authorize($currentUser, PermissionType::CREATE_TAG);
    }

    /**
     * @param \App\Supports\Interfaces\AuthInterface $currentUser
     * @param \App\Models\Taxonomy $taxonomy
     * @return mixedd
     */
    public function update(AuthInterface $currentUser, Taxonomy $taxonomy)
    {
        if (request('type') === TaxonomyEnum::CATEGORY) {
            return $this->authorize($currentUser, PermissionType::UPDATE_CATEGORY);
        }

        return $this->authorize($currentUser, PermissionType::UPDATE_TAG);
    }

    /**
     * @param \App\Supports\Interfaces\AuthInterface $currentUser
     * @param \App\Models\Taxonomy $taxonomy
     * @return mixed
     */
    public function delete(AuthInterface $currentUser, Taxonomy $taxonomy)
    {
        if (request('type') === TaxonomyEnum::CATEGORY) {
            return $this->authorize($currentUser, PermissionType::DELETE_CATEGORY);
        }

        return $this->authorize($currentUser, PermissionType::DELETE_TAG);
    }
}
