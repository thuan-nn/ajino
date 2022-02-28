<?php

namespace App\ViewModels;

use App\Enums\PostTypeEnum;
use App\Enums\TaxonomyEnum;
use App\Models\Taxonomy;
use App\Supports\Traits\ShowBannerTrait;

class ProductTaxonomyViewModel extends BaseViewModel
{
    use ShowBannerTrait;

    protected $currentTaxonomy;

    /**
     * ProductViewModel constructor.
     *
     * @param $globalData
     * @param $taxonomy
     * @param null $pageParent
     */
    public function __construct($globalData, $taxonomy, $pageParent = null)
    {
        parent::__construct($globalData);

        $this->currentPost = $pageParent;
        $this->currentTaxonomy = $taxonomy;
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

    /**
     * @return mixed
     */
    public function taxonomy()
    {
        return $this->currentTaxonomy;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|mixed[]
     */
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
                       ->when($this->currentPost && $this->currentPost->type !== PostTypeEnum::PAGE, function ($query) {
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
                        })
                       ->with('posts', function ($query) {
                           /** @var \Illuminate\Database\Query\Builder $query */
                           return $query->where([
                               'type' => PostTypeEnum::PRODUCT,
                           ]);
                       })
                       ->orderBy('order')
                       ->orderByDesc('updated_at')
                       ->get();
    }
}
