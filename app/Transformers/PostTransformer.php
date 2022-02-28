<?php

namespace App\Transformers;

use App\Enums\TaxonomyEnum;
use App\Models\Post;
use App\Supports\Traits\TransformerTrait;
use Flugg\Responder\Transformers\Transformer;
use Illuminate\Support\Arr;

class PostTransformer extends Transformer
{
    use TransformerTrait;

    /**
     * List of available relations.
     *
     * @var string[]
     */
    protected $relations = [
        'tags',
        'categories'
    ];

    /**
     * List of autoloaded default relations.
     *
     * @var array
     */
    protected $load = [];


    /**
     * Transform the model.
     *
     * @param \App\Models\Post $post
     *
     * @return array
     */
    public function transform(Post $post)
    {
        $translation = $this->checkTranslateRelations($post, $this->locale);

        return [
            'id'           => (string) $post->id,
            'parent_id'    => (string) $post->parent_id,
            'type'         => (string) $post->type,
            'is_published' => (boolean) $post->is_published,
            'order'        => (int) $post->order,
            'title'        => (string) $post->title,
            'description'  => (string) $post->description,
            'slug'         => (string) $post->slug,
            'content'      => (string) $post->content,
            'locale'       => (string) $post->locale,
            'additional'   => $this->transformAdditional($post->additional),
            'images'       => $translation ? thumbnail($translation->files()->pluck('id')) : [],
            'files'        => $translation ? thumbnail($translation->files()->pluck('id'), 'post') : [],
            'language'     => (array) $post->language,
            'created_at'   => (string) $post->created_at,
            'updated_at'   => (string) $post->updated_at,
        ];
    }

    /**
     *  Transform and query feature_posts in Addition
     *
     * @param $addition
     * @return mixed
     */
    public function transformAdditional($addition){
        $featurePosts = Arr::get($addition, 'feature_posts');
        if ($featurePosts){
            $newFeaturePosts = [];
            foreach ($featurePosts as $key => $value ){
                // Query post and check publish
                $queryPost = Post::query()->isPublished()->find($value['id']);

                // Check this post have version for this locale
                if ($queryPost && $queryPost->hasTranslation($this->locale)){
                    $postTranslate = $queryPost->translate($this->locale);
                    array_push($newFeaturePosts, [
                        'id'        => $postTranslate->post_id,
                        'title'     => $postTranslate->title
                    ]);
                }
            }
            $addition['feature_posts'] = $newFeaturePosts;
        }
        return $addition;
    }
    /**
     * @param \App\Models\Post $post
     * @return \League\Fractal\Resource\Collection
     */
    public function includeTags(Post $post)
    {
        $taxonomies = $post->taxonomies()
                           ->where('taxonomies.type', TaxonomyEnum::TAG)
                           ->wherePivot('locale', $this->locale)
                           ->whereHas('translations', function ($query) {
                               $query->where('locale', $this->locale);
                           })
                           ->isPublished()
                           ->get();

        return $this->collection($taxonomies, new TaxonomyTransformer);
    }

    /**
     * @param \App\Models\Post $post
     * @return \League\Fractal\Resource\Collection
     */
    public function includeCategories(Post $post)
    {
        $taxonomies = $post->taxonomies()
                           ->where('taxonomies.type', TaxonomyEnum::CATEGORY)
                           ->wherePivot('locale', $this->locale)
                           ->whereHas('translations', function ($query) {
                               $query->where('locale', $this->locale);
                           })
                           ->isPublished()
                           ->get();

        return $this->collection($taxonomies, new TaxonomyTransformer);
    }
}
