<?php

namespace App\ViewModels;

use App\Enums\FileTypeEnum;
use App\Models\Post;
use App\Supports\Traits\BreadcrumbTrait;
use App\Supports\Traits\ShowBannerTrait;
use App\Transformers\PostTransformer;
use Illuminate\Support\Arr;

class StaticPageViewModel extends BaseViewModel
{
    use BreadcrumbTrait, ShowBannerTrait;

    public function __construct($globalData, $post, $postParent = null)
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
     * @return array
     */
    public function postParent()
    {
        if (! $this->postParent) {
            return null;
        }

        return (new PostTransformer)->transform($this->postParent);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|object|null
     */
    public function featuredPosts()
    {
        /** @var \Illuminate\Database\Query\Builder $postQuery */
        $postQuery = Post::query()
                         ->translatedIn($this->locale)
                         ->with('translation.files')
                         ->where('is_published', 1)
                         ->where('id', '<>', $this->currentPost->id)
                         ->where('type', '=', $this->currentPost->type)
                         ->orderBy('updated_at', 'desc')
                         ->limit(3);

        $features = Arr::get($this->currentPost->additional, 'feature_posts');
        if ($features) {
            $featureIds = Arr::get($features, 'key');

            $postQuery->whereIn('id', $featureIds);
        }

        return $postQuery->where([
            'is_published' => 1,
            'type'         => $this->currentPost->type,
            'parent_id'    => $this->postParentId,
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
