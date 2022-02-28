<?php

namespace App\ViewModels;

use App\Enums\LocationEnum;
use App\Enums\MajorEnum;
use App\Models\Location;
use App\Models\Post;
use App\Supports\Traits\CaptchaKeyTrait;
use App\Supports\Traits\ShowBannerTrait;

class CompanyTourViewModel extends BaseViewModel
{
    use ShowBannerTrait, CaptchaKeyTrait;

    public function __construct($globalData, $post, $postParent)
    {
        parent::__construct($globalData);

        $this->currentPost = $post;
        $this->postParent = $postParent;
    }

    /**
     * @return \App\Models\Post
     */
    public function page()
    {
        /** @var Post $page */
        return $this->currentPost;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function locations()
    {
        return Location::query()
                       ->where('additional->tour_page', '=', true)
                       ->where('type', LocationEnum::VISIT)->get();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function locationVisitors()
    {
        return Location::query()->where('type', LocationEnum::JOB)->get();
    }

    /**
     * @return array
     */
    public function majors()
    {
        return MajorEnum::asSelectArray();
    }
}
