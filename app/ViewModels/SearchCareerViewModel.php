<?php

namespace App\ViewModels;

use App\Enums\LocationEnum;
use App\Models\Job;
use App\Models\Location;
use App\Models\Post;
use App\Supports\Traits\ShowBannerTrait;
use App\Supports\Traits\TransformerViewTrait;
use App\Transformers\JobTransformer;
use App\Transformers\PostTransformer;

class SearchCareerViewModel extends BaseViewModel
{
    use TransformerViewTrait, ShowBannerTrait;

    protected $pagination;

    protected $searchData;

    public function __construct($globalData, $post, $searchData)
    {
        parent::__construct($globalData);

        $this->currentPost = $post;
        $this->searchData = $searchData;
        $this->pagination = 12;
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
    public function searchData()
    {
        return $this->searchData;
    }

    /**
     * @return array
     */
    public function jobs()
    {
        $key = isset($this->searchData['key']) ? $this->searchData['key'] : null;
        $place = isset($this->searchData['place']) ? $this->searchData['place'] : null;

        $jobQuery = Job::query()
                       ->translatedIn($this->locale)
                       ->where('is_published', 1)
                       ->when($key, function ($query) use ($key) {
                           /** @var \Illuminate\Database\Query\Builder $query */
                           return $query->where(function ($query) use ($key) {
                               /** @var \Illuminate\Database\Query\Builder $query */
                               return $query->whereTranslationLike('title', '%'.$key.'%')
                                            ->orWhereTranslationLike('job_type', '%'.$key.'%');
                           });
                       })
                       ->when($place, function ($query) use ($place) {
                           /** @var \Illuminate\Database\Query\Builder $query */
                           return $query->whereHas('location', function ($query) use ($place) {
                               /** @var \Illuminate\Database\Query\Builder $query */
                               return $query->where('id', $place);
                           });
                       })->orderByDesc('updated_at');

        return $this->transformPagination($jobQuery, new JobTransformer, $this->pagination);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function locations()
    {
        return Location::query()->where('type', LocationEnum::JOB)->get();
    }
}
