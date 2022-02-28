<?php

namespace App\ViewModels;

use App\Enums\TaxonomyEnum;
use App\Models\Taxonomy;

class CateVerticalPageViewModel extends PageViewModel
{
    public function __construct($postId, $postParent = null)
    {
        parent::__construct($postId, $postParent);
        $this->postId = $postId;
        $this->postParent = $postParent;
    }

    /**
     * @return mixed
     */
    public function categories()
    {
        return Taxonomy::query()
                       ->translatedIn($this->locale)
                       ->isPublished()
                       ->where('type', TaxonomyEnum::CATEGORY)
                       ->whereHas('posts', function ($post) {
                           $post->isPublished()->where('parent_id', $this->postId);
                       })->orderByDesc('updated_at')->get();
    }
}
