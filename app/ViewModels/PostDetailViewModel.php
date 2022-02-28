<?php

namespace App\ViewModels;

use App\Enums\FileTypeEnum;
use App\Models\Post;
use App\Supports\Traits\BreadcrumbTrait;
use Illuminate\Support\Arr;

class PostDetailViewModel extends BaseViewModel
{
    use BreadcrumbTrait;

    /** @var Post $post */
    protected $post;

    public function __construct($globalData, $post, $postParent)
    {
        parent::__construct($globalData);

        $this->currentPost = $post;
        $this->postParent = $postParent;
    }

    /**
     * @return \App\Models\Post
     */
    public function postDetail()
    {
        return $this->currentPost;
    }

    /**
     * @return \App\Models\Post
     */
    public function postParent()
    {
        /** @var Post $post */
        return $this->postParent;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|object|null
     */
    public function featuredPosts()
    {
        /** @var \Illuminate\Database\Query\Builder $postQuery */
        $postQuery = Post::query()
                         ->with('translation.files')
                         ->where('is_published', 1)
                         ->translatedIn($this->locale)
                         ->when($this->currentPost, function ($query) {
                             /** @var \Illuminate\Database\Eloquent\Builder $query */
                             return $query->where('id', '<>', $this->currentPost->id)
                                          ->where('type', '=', $this->currentPost->type);
                         })
                         ->orderBy('updated_at', 'desc')
                         ->limit(3);

        if ($this->currentPost && $features = Arr::get($this->currentPost->additional, 'feature_posts')) {
            //$featureIds = Arr::get($features, 'key');
            $featureIds = Arr::flatten($features);

            $postQuery->whereIn('id', $featureIds);
        }

        return $postQuery->where([
            'is_published' => 1,
            'type'         => optional($this->currentPost)->type,
            //'parent_id'    => optional($this->postParent)->id,
        ])->get();
    }

    /**
     * @return string
     */
    public function thumbnailUrl()
    {
        return getImageUrl($this->currentPost, FileTypeEnum::THUMBNAIL);
    }

    /**
     * @return string
     */
    public function coverUrl()
    {
        return getImageUrl($this->currentPost, FileTypeEnum::COVER);
    }
}
