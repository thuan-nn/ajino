<?php

namespace App\ViewModels;

use App\Models\Post;

class SearchPostViewModel extends BaseViewModel
{
    protected $searchData;

    public function __construct($globalData, $searchData)
    {
        parent::__construct($globalData);

        $this->searchData = $searchData;
    }

    /**
     * @return mixed
     */
    public function searchData()
    {
        return $this->searchData;
    }

    /**
     * @return mixed
     */
    public function listPost()
    {
        $key = $this->searchData['post'];

        $listPost = Post::query()
                        ->where('is_published', 1)
                        ->translatedIn($this->locale)
                        ->whereTranslationLike('title', '%'.$key.'%', $this->locale)
                        ->orWhereTranslationLike('content', '%'.$key.'%', $this->locale)
                        ->orWhereTranslationLike('description', '%'.$key.'%', $this->locale)
                        ->orderByDesc('updated_at')
                        ->paginate(12);

        return $listPost->appends(['post' => $key]);
    }
}
