<?php

namespace App\Policies;

use App\Enums\PermissionType;
use App\Enums\PostTypeEnum;
use App\Models\Post;
use App\Supports\Interfaces\AuthInterface;
use Illuminate\Support\Arr;

class PostPolicy extends BasePolicy
{
    /**
     * @param AuthInterface $currentUser
     *
     * @return mixed
     */
    public function viewAny(AuthInterface $currentUser)
    {
        $type = Arr::get(request('filters'), 'type');

        switch ($type){
            case PostTypeEnum::STORY_GROUP:
            case PostTypeEnum::STORY_VN:
                return $this->authorize($currentUser, PermissionType::VIEW_STORY);
            case PostTypeEnum::PRODUCT:
                return $this->authorize($currentUser, PermissionType::VIEW_PRODUCT);
            case PostTypeEnum::NEWS:
                return $this->authorize($currentUser, PermissionType::VIEW_NEWS);
            case PostTypeEnum::UMAMI:
                return $this->authorize($currentUser, PermissionType::VIEW_UMAMI);
            default:
                return $this->authorize($currentUser, PermissionType::VIEW_PAGE);
        }
    }

    /**
     * @param AuthInterface $currentUser
     *
     * @param Post $post
     *
     * @return mixed
     */
    public function view(AuthInterface $currentUser, Post $post)
    {
        $type = Arr::get(request('filters'), 'type');

        switch ($type){
            case PostTypeEnum::STORY_GROUP:
            case PostTypeEnum::STORY_VN:
                return $this->authorize($currentUser, PermissionType::VIEW_STORY);
            case PostTypeEnum::PRODUCT:
                return $this->authorize($currentUser, PermissionType::VIEW_PRODUCT);
            case PostTypeEnum::NEWS:
                return $this->authorize($currentUser, PermissionType::VIEW_NEWS);
            case PostTypeEnum::UMAMI:
                return $this->authorize($currentUser, PermissionType::VIEW_UMAMI);
            default:
                return $this->authorize($currentUser, PermissionType::VIEW_PAGE);
        }
    }

    /**
     * @param AuthInterface $currentUser
     *
     * @return mixed
     */
    public function create(AuthInterface $currentUser)
    {
        $type = request('type');

        switch ($type){
            case PostTypeEnum::STORY_GROUP:
            case PostTypeEnum::STORY_VN:
                return $this->authorize($currentUser, PermissionType::VIEW_STORY);
            case PostTypeEnum::PRODUCT:
                return $this->authorize($currentUser, PermissionType::CREATE_PRODUCT);
            case PostTypeEnum::NEWS:
                return $this->authorize($currentUser, PermissionType::CREATE_NEWS);
            case PostTypeEnum::UMAMI:
                return $this->authorize($currentUser, PermissionType::CREATE_UMAMI);
            default:
                return $this->authorize($currentUser, PermissionType::CREATE_PAGE);
        }
    }

    /**
     * @param AuthInterface $currentUser
     * @param \App\Models\Post $post
     * @return mixed
     */
    public function update(AuthInterface $currentUser, Post $post)
    {
        $type = request('type');

        switch ($type){
            case PostTypeEnum::STORY_GROUP:
            case PostTypeEnum::STORY_VN:
                return $this->authorize($currentUser, PermissionType::VIEW_STORY);
            case PostTypeEnum::PRODUCT:
                return $this->authorize($currentUser, PermissionType::UPDATE_PRODUCT);
            case PostTypeEnum::NEWS:
                return $this->authorize($currentUser, PermissionType::UPDATE_NEWS);
            case PostTypeEnum::UMAMI:
                return $this->authorize($currentUser, PermissionType::UPDATE_UMAMI);
            default:
                return $this->authorize($currentUser, PermissionType::UPDATE_PAGE);
        }
    }

    /**
     * @param AuthInterface $currentUser
     * @param \App\Models\Post $post
     * @return mixed
     */
    public function delete(AuthInterface $currentUser, Post $post)
    {
        $type = request('type');

        switch ($type){
            case PostTypeEnum::STORY_GROUP:
            case PostTypeEnum::STORY_VN:
                return $this->authorize($currentUser, PermissionType::VIEW_STORY);
            case PostTypeEnum::PRODUCT:
                return $this->authorize($currentUser, PermissionType::DELETE_PRODUCT);
            case PostTypeEnum::NEWS:
                return $this->authorize($currentUser, PermissionType::DELETE_NEWS);
            case PostTypeEnum::UMAMI:
                return $this->authorize($currentUser, PermissionType::DELETE_UMAMI);
            default:
                return $this->authorize($currentUser, PermissionType::DELETE_PAGE);
        }
    }
}
