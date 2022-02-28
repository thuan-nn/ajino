<?php

namespace App\ViewModels;

class PostPageViewModel extends PageViewModel
{
    public function __construct($globalData, $post, $postParent)
    {
        parent::__construct($globalData, $post, $postParent);
    }
}
