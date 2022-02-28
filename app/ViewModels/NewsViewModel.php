<?php

namespace App\ViewModels;

use App\Enums\PostTypeEnum;
use App\Models\Post;
use App\Supports\Traits\ShowBannerTrait;
use App\Supports\Traits\TransformerViewTrait;
use App\Transformers\PostTransformer;

class NewsViewModel extends BaseViewModel
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
        /** @var Post $page */
        $page = $this->currentPost;

        return (new PostTransformer)->transform($page);
    }

    /**
     * @return array
     */
    public function posts()
    {
        $postsQuery = Post::query()
                          ->where('is_published', 1)
                          ->where('type', PostTypeEnum::NEWS)
                          ->translatedIn($this->locale())
                          ->with('translation.files')
                          ->orderByDesc('updated_at');

        return $this->transformPagination($postsQuery, new PostTransformer, $this->pagination);
    }
}
