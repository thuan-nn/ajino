<?php

namespace App\ViewModels;

use App\Enums\LocationEnum;
use App\Models\Location;
use App\Supports\Traits\CaptchaKeyTrait;
use App\Supports\Traits\ShowBannerTrait;
use App\Supports\Traits\BreadcrumbTrait;

class ContactViewModel extends BaseViewModel
{
    use  CaptchaKeyTrait, BreadcrumbTrait, ShowBannerTrait;

    public function __construct($globalData, $post, $postParent)
    {
        parent::__construct($globalData);

        $this->currentPost = $post;
        $this->postParent = $postParent;
    }

    /**
     * @return \App\Models\Post
     */
    public function post()
    {
        return $this->currentPost;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function locationCompanies()
    {
        return Location::query()->where('type', LocationEnum::VISIT)
                       ->where('additional->contact_page', '=', true)->get();
    }
}
