<?php

namespace App\ViewModels;

use App\Enums\FileTypeEnum;
use App\Enums\TaxonomyEnum;
use App\Models\Post;
use App\Models\PostTranslation;
use App\Models\Taxonomy;

class CateHorizontalPageViewModel extends PageViewModel
{
    public function __construct($postId, $postParent = null)
    {
        parent::__construct($postId, $postParent);
        $this->postId = $postId;
        $this->postParent = $postParent;
    }

    public function categories()
    {
        return Taxonomy::query()
                       ->translatedIn($this->locale)
                       ->isPublished()
                       ->where('type', TaxonomyEnum::CATEGORY)
                       ->whereHas('posts', function ($post) {
                           $post->isPublished()->where('parent_id', $this->postId);
                       })
                       ->orderByDesc('updated_at')->get();
    }
}