<?php

namespace App\Actions;

use App\Enums\TaxonomyEnum;
use App\Models\Post;
use App\Models\Taxonomy;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class AssignTaxonomyAction
{
    /**
     * @param $data
     * @param \App\Models\Post $post
     * @param $locale
     * @throws \Throwable
     */
    public function assignTags($data, Post $post, $locale){
        $createTaxonomyAction = new CreateTaxonomyAction();
        // Assign tags
        $tags = Arr::get($data, 'tags') ?: [];
        foreach ($tags as $tag) {
            if (! Arr::get($tag, 'id')) {
                // Check Tag exist
                $createdTag = Taxonomy::query()
                                      ->isPublished()
                                      ->where('type', TaxonomyEnum::TAG)
                                      ->whereHas('translations', function ($query) use ($locale, $tag) {
                                          $query->where('locale', $locale)
                                                ->whereRaw("BINARY title = ? ", $tag['title']);
                                      })
                                      ->first();
                if (!$createdTag){
                    $dataTag = [
                        'type'  => TaxonomyEnum::TAG,
                        'order' => 0,
                        'title' => trim($tag['title'])
                    ];
                    $createdTag = $createTaxonomyAction->execute($dataTag, $locale);
                }

            } else {
                $createdTag = Taxonomy::query()
                                      ->isPublished()
                                      ->where('type', TaxonomyEnum::TAG)
                                      ->find(Arr::get($tag, 'id'));
            }

            // Check: created Tag has type same post type
            if ($createdTag){
                    DB::table('taxonomy_posts')
                  ->insert([
                      'post_id' => $post->id,
                      'locale' => $locale,
                      'taxonomy_id' => $createdTag->id
                  ]);
            }
        }
    }

    /**
     * @param $data
     * @param \App\Models\Post $post
     * @param $locale
     */
    public function assignCategories($data, Post $post, $locale){
        // Assign Categories
        $categories = Arr::get($data, 'categories') ?: [];
        foreach ($categories as $category) {
            $createdCategory = Taxonomy::query()
                                       ->isPublished()
                                       ->where('type', TaxonomyEnum::CATEGORY)
                                       ->where('page', $data['type'])
                                       ->find(Arr::get($category, 'id'));

            // Check: created Category has type same post type
            if ($createdCategory){
                DB::table('taxonomy_posts')
                    ->insert([
                        'post_id' => $post->id,
                        'locale' => $locale,
                        'taxonomy_id' => $createdCategory->id
                    ]);
            }
        }
    }
}
