<?php

namespace App\ViewModels;

class SinglePageViewModel extends PageViewModel
{
    public function __construct($globalData, $post, $postParent = null)
    {
        parent::__construct($globalData, $post, $postParent);
    }
}
