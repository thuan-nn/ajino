<?php

namespace App\ViewModels;

use App\Enums\PostTypeEnum;
use App\Models\Post;
use App\Supports\Traits\BreadcrumbTrait;

class UmamiVideoViewModel extends BaseViewModel
{
    use BreadcrumbTrait;

    protected $taxonomyId;

    protected $taxonomy;

    public function __construct($globalData, $taxonomy, $taxonomyId)
    {
        parent::__construct($globalData);

        $this->taxonomy = $taxonomy;
        $this->taxonomyId = $taxonomyId;
    }

    /**
     * @return \App\Models\Post
     */
    public function page()
    {
        return $this->taxonomy;
    }

    /**
     * @return mixed
     */
    public function features()
    {
        return Post::query()
                   ->translatedIn($this->locale)
                   ->where(['is_published' => 1, 'type' => PostTypeEnum::UMAMI])
                   ->whereTranslation('additional->is_feature_video', true)
                   ->whereHas('taxonomies', function ($query) {
                       /** @var \Illuminate\Database\Query\Builder $query */
                       return $query->where('id', $this->taxonomyId);
                   })
                   ->orderByDesc('updated_at')
                   ->get();
    }

    /**
     * @return mixed
     */
    public function recipes()
    {
        return Post::query()
                   ->translatedIn($this->locale)
                   ->where(['is_published' => 1, 'type' => PostTypeEnum::UMAMI])
                   ->whereHas('taxonomies', function ($query) {
                       /** @var \Illuminate\Database\Query\Builder $query */
                       return $query->where('id', $this->taxonomyId);
                   })
                   ->orderByDesc('updated_at')
                   ->paginate(9);
    }
}
