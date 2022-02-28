<?php

namespace App\ViewModels;

use App\Enums\PostTypeEnum;
use App\Models\Post;
use App\Models\Taxonomy;
use App\Supports\Traits\ShowBannerTrait;
use App\Supports\Traits\TransformerViewTrait;
use App\Transformers\PostTransformer;
use App\Transformers\TaxonomyTransformer;

class TaxonomyVerticalViewModel extends BaseViewModel
{
    use TransformerViewTrait, ShowBannerTrait;

    protected $pagination;

    protected $taxonomyId;

    public function __construct($globalData, $post, $taxonomyId)
    {
        parent::__construct($globalData);

        $this->currentPost = $post;
        $this->taxonomyId = $taxonomyId;
        $this->pagination = 12;
    }

    /**
     * @return mixed
     */
    public function page()
    {
        /** @var Taxonomy $taxonomy */
        $taxonomy = Taxonomy::query()
                            ->translatedIn($this->locale)
                            ->where(['is_published' => 1])
                            ->findOrFail($this->taxonomyId);

        $taxonomyTransformed = (new TaxonomyTransformer)->transform($taxonomy);

        if ((! $taxonomy || count($taxonomyTransformed['images']) === 0) && $this->currentPost) {
            /** @var Post $post */
            $post = Post::query()->translatedIn($this->locale)->whereTranslation('id', $this->currentPost->id)->first();

            if ($post) {
                $taxonomyTransformed = (new PostTransformer)->transform($post);
            }
        }

        return $taxonomyTransformed;
    }

    /**
     * @return mixed
     */
    public function posts()
    {
        $postsQuery = Post::query()
                          ->translatedIn($this->locale)
                          ->where([
                              'is_published' => 1,

                          ])
                          ->whereHas('taxonomies', function ($query) {
                              /** @var \Illuminate\Database\Query\Builder $query */
                              return $query->where('id', $this->taxonomyId);
                          })
                          ->orderByDesc('updated_at');

        return $this->transformPagination($postsQuery, new PostTransformer, $this->pagination);
    }
}
