<?php

namespace App\ViewModels;

use App\Enums\MenuTypeEnum;
use App\Models\MenuLink;
use App\Supports\Traits\BreadcrumbTrait;

class SitemapViewModel extends BaseViewModel
{
    use BreadcrumbTrait;

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
    public function menuLinks()
    {
        //$menu_name = [MenuTypeEnum::MAIN_RIGHT, MenuTypeEnum::MAIN_LEFT, MenuTypeEnum::FOOTER_BOTTOM];

        if (!$this->globalData['menus']) {
            return [];
        }

        return $this->globalData['menus']->filter(function ($menu) {
            return $menu->menu->type === MenuTypeEnum::MAIN_LEFT;
        });
    }
}
