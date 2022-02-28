<?php

namespace App\ViewModels;

use App\Enums\LocationEnum;
use App\Models\Job;
use App\Models\Location;
use App\Models\Post;
use App\Supports\Traits\CaptchaKeyTrait;
use App\Supports\Traits\ShowBannerTrait;
use App\Supports\Traits\TransformerViewTrait;
use App\Transformers\JobTransformer;
use App\Transformers\PostTransformer;

class CareerViewModel extends BaseViewModel
{
    use TransformerViewTrait, ShowBannerTrait, CaptchaKeyTrait;

    protected $pagination;

    public function __construct($globalData, $post, $postParent = null)
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
     * @return mixed
     */
    public function newJobs()
    {
        /** @var Job $jobs */
        $jobQuery = Job::query()
                       ->translatedIn($this->locale)
                       ->where(['is_published' => 1])
                       ->whereTranslation('additional->is_hot', true)
                       ->whereHas('translation')
                       ->orderByDesc('updated_at')
                       ->with('translation.files')
                       ->limit(3);

        return $this->transformPagination($jobQuery, new JobTransformer, 3);
    }

    /**
     * @return mixed
     */
    public function jobs()
    {
        $jobQuery = Job::query()
                       ->translatedIn($this->locale)
                       ->where(['is_published' => 1])
                       ->whereHas('translation')
                       ->with('translation.files');

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
