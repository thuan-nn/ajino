<?php

namespace App\Actions;

use App\Enums\TaxonomyEnum;
use App\Models\Post;
use App\Supports\Traits\HandleTranslations;
use Illuminate\Support\Facades\DB;

class UpdatePostAction
{
    use HandleTranslations;

    /**
     * @param array $data
     * @param Post $post
     *
     * @param $locale
     * @throws \Throwable
     */
    public function execute(array $data, Post $post, $locale)
    {
        $postData = $this->handleData($data, (string) $locale, $post);
        $assignTaxonomyAction = new AssignTaxonomyAction();

        DB::beginTransaction();
        try {
            $post->update($postData);

            $this->attachFiles($post, $data, $locale);

            // Remove relation with Tags in this locale first and then assign new tags
             $tags = $post->taxonomies()
                         ->where('taxonomies.type', TaxonomyEnum::TAG)
                         ->wherePivot('locale', $locale)
                         ->get();
            $tags->each(function ($tag) use($post, $locale){
                $post->taxonomies()->where('id', $tag->id)->wherePivot('locale', $locale)->detach();
            });


            $assignTaxonomyAction->assignTags($data, $post, $locale);

            // Remove relation with Categories in this locale first and then assign new categories
             $categories = $post->taxonomies()
                         ->where('taxonomies.type', TaxonomyEnum::CATEGORY)
                          ->wherePivot('locale', $locale)
                         ->get();
            $categories->each(function ($category) use($post, $locale){
                $post->taxonomies()->where('id', $category->id)->wherePivot('locale', $locale)->detach();
            });

            $assignTaxonomyAction->assignCategories($data, $post, $locale);

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new $exception;
        }
    }
}
