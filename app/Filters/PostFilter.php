<?php

namespace App\Filters;

use App\Enums\TaxonomyEnum;
use App\Supports\Traits\SearchDefaultTranslations;
use Illuminate\Support\Facades\DB;

class PostFilter extends Filter
{
    use SearchDefaultTranslations;

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
     * @param $type
     * @return \App\Supports\Builder
     */
    public function type($type)
    {
        return $this->query->where('type', $type);
    }

    /**
     * @param $content
     * @return \App\Supports\Builder|\Illuminate\Database\Eloquent\Builder
     */
    public function content($content)
    {
        return $this->query->whereUnicode($content, 'content');
    }

    /**
     * @param mixed $ids
     * @return \App\Supports\Builder
     */
    public function notInIds($ids)
    {
        $postIds = is_string($ids) ? explode(',', $ids) : $ids;

        return $this->query->whereNotIn('id', $postIds);
    }

    /**
     *
     * @param $locale
     * @return \App\Supports\Builder|\Illuminate\Database\Eloquent\Builder
     */
    public function has_locale($locale)
    {
        return $this->query->whereHas('translations', function ($query) use ($locale) {
            $query->where('locale', $locale);
        });
    }

    /**
     * @param $template
     * @return \App\Supports\Builder|\Illuminate\Database\Eloquent\Builder
     */
    public function template($template)
    {
        return $this->query->whereHas('translations', function ($query) use ($template) {
            /** @var \Illuminate\Database\Eloquent\Builder $query */
            return $query->where('additional->template', $template);
        });
    }

    /**
     * @param $categoryId
     * @return \App\Supports\Builder|\Illuminate\Database\Eloquent\Builder
     */
    public function category($categoryId)
    {
        return $this->query->whereHas('taxonomies', function ($query) use ($categoryId) {
            /** @var \Illuminate\Database\Eloquent\Builder $query */
            return $query->where('id', $categoryId)
                         ->whereType(TaxonomyEnum::CATEGORY);
        });
    }

    /**
     * @param $postId
     * @return \App\Supports\Builder
     */
    public function notIn($postId)
    {
        $postIds = $this->getPostIds($postId);

        array_push($postIds, $postId);

        return $this->query->whereNotIn('id', $postIds);
    }

    /**
     * @param $postId
     * @return array
     */
    private function getPostIds($postId)
    {
        $statement = DB::select("with recursive cte_post (id, parent_id) as (
                                          select     id,
                                                     parent_id
                                          from       posts
                                          where      parent_id = ?
                                          union all
                                          select     p.id,
                                                     p.parent_id
                                          from       posts p
                                          inner join cte_post
                                                  on p.parent_id = cte_post.id
                                        )
                                        select * from cte_post;
                                        ", [$postId]);

        return array_map(function ($item) {
            return $item->id;
        }, $statement);
    }
}
