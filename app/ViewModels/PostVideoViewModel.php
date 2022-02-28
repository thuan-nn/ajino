<?php

namespace App\ViewModels;

use App\Models\Post;

class PostVideoViewModel extends BaseViewModel
{
    public function __construct($globalData, $post, $postParent)
    {
        parent::__construct($globalData);

        $this->currentPost = $post;
        $this->postParent = $postParent;
    }

    /**
     * @return mixed
     */
    public function postFeatures()
    {
        return Post::query()
                   ->translatedIn($this->locale)
                   ->isPublished()
                   ->whereTranslation('additional->is_featured', 1)
                   ->where('parent_id', $this->currentPost->id)
                   ->orderByDesc('updated_at')
                   ->get();
    }

    /**
     * @return mixed
     */
    public function postRecipes()
    {
        return Post::query()
                   ->isPublished()
                   ->where('parent_id', $this->currentPost->id)
                   ->orderByDesc('updated_at')
                   ->paginate(9);
    }
}
