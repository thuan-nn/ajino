<?php

namespace App\Actions;

use App\Enums\PostTypeEnum;
use App\Models\Post;
use App\Supports\Traits\HandleTranslations;
use Illuminate\Support\Facades\DB;

class CreatePostAction
{
    use HandleTranslations;

    /**
     * @param $data
     *
     * @param string $locale
     * @return mixed
     * @throws \Throwable
     */
    public function execute($data, string $locale)
    {
        $post = new Post();
        $assignTaxonomyAction = new AssignTaxonomyAction();
        $postData = $this->handleData($data, $locale, $post);

        DB::beginTransaction();
        try {
            if ($postData['type'] === PostTypeEnum::FS_PRODUCT && !isset($postData['order'])) {
                $post = Post::where('type', PostTypeEnum::FS_PRODUCT)
                            ->orderBy('order', 'desc')
                            ->first();
                $postData['order'] = $post ? $post->order++ : 1;
            }
            $post = $post->create($postData);

            $this->attachFiles($post, $data, $locale);

            // Assign Tags
            $assignTaxonomyAction->assignTags($data, $post, $locale);
            // Assign Categories
            $assignTaxonomyAction->assignCategories($data, $post, $locale);

            DB::commit();
        } catch (\HttpException $httpException) {
            DB::rollBack();
            throw new $httpException->getMessage();
        }

        return $post;
    }
}
