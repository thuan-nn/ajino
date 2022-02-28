<?php

namespace App\Filters;

use App\Builders\PostBuilder;

class BannerFilter extends Filter
{
    /**
     * @param $title
     *
     * @return \App\Supports\Builder
     */
    public function title($title)
    {
        return $this->query->whereTranslationLike('title', '%'.$title.'%');
    }

    /**
     * @param $content
     * @return \App\Supports\Builder
     */
    public function content($content)
    {
        return $this->query->whereTranslationLike('content', '%'.$content.'%');
    }

    /**
     * @param $isPublished
     *
     * @return \App\Supports\Builder
     */
    public function is_published($isPublished)
    {
        return $this->query->where('is_published', $isPublished);
    }

    /**
     * @param $title
     * @return \App\Supports\Builder|\Illuminate\Database\Eloquent\Builder
     */
    public function postTitle($title)
    {
        return $this->query->whereHas('post', function (PostBuilder $post) use ($title) {
            return $post->whereTranslationLike('title', '%'.$title.'%');
        });
    }

    public function postIsPublished($isPublished)
    {
        return $this->query->whereHas('post', function (PostBuilder $post) use ($isPublished) {
            return $post->where('is_pusblished', $isPublished);
        });
    }
}
