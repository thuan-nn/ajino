<?php

namespace App\ViewModels;

use App\Enums\PostTypeEnum;
use App\Models\Post;
use App\Supports\Traits\ShowBannerTrait;
use App\Supports\Traits\TransformerViewTrait;
use App\Transformers\PostTransformer;

class AboutUsViewModel extends BaseViewModel
{
    use TransformerViewTrait, ShowBannerTrait;

    protected $pagination;

    public function __construct($globalData, $post, $postParent)
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
    public function page()
    {
        /** @var Post $page */
        return $this->currentPost;
    }

    /**
     * @return array
     */
    public function posts()
    {
        $postsQuery = Post::query()
                          ->translatedIn($this->locale)
                          ->where('is_published', 1)
                          ->where('parent_id', $this->currentPost->id)
            //->orWhere('id', $this->postId)
                          ->where('type', PostTypeEnum::PAGE)
                          ->with('translation.files')
                          ->orderByDesc('updated_at');

        return $this->transformPagination($postsQuery, new PostTransformer, $this->pagination);
    }
}
