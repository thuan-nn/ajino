<?php

namespace App\ViewModels;

use App\Models\Job;
use App\Models\Post;
use App\Supports\Traits\BreadcrumbTrait;

class PageViewModel extends BaseViewModel
{
    use BreadcrumbTrait;

    public function __construct($globalData, $post, $postParent = null)
    {
        parent::__construct($globalData);

        $this->currentPost = $post;
        $this->postParent = $postParent;
    }

    /**
     * Get post
     *
     * @return mixed
     */
    public function post()
    {
        return $this->currentPost;
    }

    /**
     * Get paginate post page children
     *
     * @return mixed
     */
    public function postChildren()
    {
        return Post::query()
                   ->translatedIn($this->locale)
                   ->where('is_published', 1)
                   ->where('parent_id', $this->postId)
                   ->orderBy('order')
                   ->orderByDesc('updated_at')
                   ->paginate(12);
    }

    /**
     * Get post parent
     *
     * @return mixed
     */
    public function postParent()
    {
        return $this->postParent;
    }
}
