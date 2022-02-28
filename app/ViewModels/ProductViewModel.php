<?php

namespace App\ViewModels;

use App\Enums\PostTypeEnum;
use App\Enums\TaxonomyEnum;
use App\Models\Post;
use App\Models\Taxonomy;
use App\Supports\Traits\ShowBannerTrait;

class ProductViewModel extends BaseViewModel
{
    use ShowBannerTrait;

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
    public function page()
    {
        return $this->currentPost;
    }

    public function categories()
    {
        /** @var Taxonomy $taxonomies */
        return Taxonomy::query()
                       ->translatedIn($this->locale)
                       ->where([
                           'type'         => TaxonomyEnum::CATEGORY,
                           'page'         => PostTypeEnum::PRODUCT,
                           'is_published' => 1,
                       ])
                       ->when($this->currentPost, function ($query) {
                           /** @var \Illuminate\Database\Eloquent\Builder $query */
                           return $query->whereHas('translations', function ($query) {
                               /** @var \Illuminate\Database\Eloquent\Builder $query */
                               return $query->where('additional->page', $this->currentPost->id);
                           });
                       })
                       ->whereHas('posts', function ($query) {
                           /** @var \Illuminate\Database\Query\Builder $query */
                           return $query->where([
                               'type'         => PostTypeEnum::PRODUCT,
                               'is_published' => 1,
                           ]);
                       })->orderBy('order')
                         ->orderByDesc('updated_at')
                         ->get();
    }
}
