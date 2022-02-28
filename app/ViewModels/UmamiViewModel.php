<?php

namespace App\ViewModels;

use App\Enums\PostTypeEnum;
use App\Enums\TaxonomyEnum;
use App\Models\Post;
use App\Models\Taxonomy;
use App\Supports\Traits\ShowBannerTrait;
use App\Supports\Traits\TransformerViewTrait;
use App\Transformers\PostTransformer;
use App\Transformers\TaxonomyTransformer;
use League\Fractal\Resource\Collection;

class UmamiViewModel extends BaseViewModel
{
    use TransformerViewTrait, ShowBannerTrait;

    /**
     * @var mixed
     */
    protected $pagination;

    /**
     * UmamiViewModel constructor.
     *
     * @param $globalData
     * @param $post
     * @param null $postParent
     */
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

    /**
     * @return array
     */
    public function posts()
    {
        $postsQuery = Post::query()
                          ->translatedIn($this->locale)
                          ->where('is_published', 1)
                          ->where('type', PostTypeEnum::UMAMI)
                          ->with('translation.files')
                          ->orderByDesc('updated_at');

        return $this->transformPagination($postsQuery, new PostTransformer, $this->pagination);
    }

    /**
     * @return mixed
     */
    public function categories()
    {
        /** @var Taxonomy $taxonomies */
        $taxonomies = Taxonomy::query()
                              ->translatedIn($this->locale)
                              ->where([
                                  'type'         => TaxonomyEnum::CATEGORY,
                                  'page'         => PostTypeEnum::UMAMI,
                                  'is_published' => 1,
                              ])
                              ->when($this->currentPost, function (
                                  $query
                              ) {
                                  /** @var \Illuminate\Database\Eloquent\Builder $query */
                                  return $query->whereHas('translations', function ($query) {
                                      /** @var \Illuminate\Database\Eloquent\Builder $query */
                                      return $query->where('additional->page', $this->currentPost->id);
                                  });
                              })
                              ->with('posts', function ($query) {
                                  /** @var \Illuminate\Database\Query\Builder $query */
                                  return $query->wherePivot('locale', $this->locale())->where([
                                      'type'         => PostTypeEnum::UMAMI,
                                      'is_published' => 1,
                                  ])->translatedIn($this->locale)
                                               ->orderBy('order', 'ASC')
                                               ->orderBy('updated_at', 'DESC');
                              })
                              ->orderBy('order', 'ASC')
                              ->orderBy('updated_at', 'DESC')
                              ->get();

        $resources = new Collection($taxonomies, new TaxonomyTransformer);

        return $resources->getData();
    }
}
