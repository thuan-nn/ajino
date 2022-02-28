<?php

namespace App\ViewModels;

use App\Enums\PostTypeEnum;
use App\Models\Post;
use App\Supports\Traits\ShowBannerTrait;
use App\Supports\Traits\TransformerViewTrait;
use App\Transformers\PostTransformer;

class StoryVnViewModel extends BaseViewModel
{
    use TransformerViewTrait, ShowBannerTrait;

    protected $pagination;

    public function __construct($globalData, $post, $postParent)
    {
        parent::__construct($globalData);

        $this->currentPost = $post;
        $this->postParent = $postParent;
        $this->pagination = 9;
    }

    /**
     * Get post
     *
     * @return mixed
     */
    public function page()
    {
        return (new PostTransformer)->transform($this->currentPost);
    }

    /**
     * @return array
     */
    public function posts()
    {
        $postsQuery = Post::query()
                          ->translatedIn($this->locale)
                          ->where('is_published', 1)
                          ->where('type', PostTypeEnum::STORY_VN)
                          ->with('translation.files')
                          ->orderByDesc('updated_at');

        return $this->transformPagination($postsQuery, new PostTransformer, $this->pagination);
    }
}
