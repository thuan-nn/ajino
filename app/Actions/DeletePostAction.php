<?php

namespace App\Actions;

use App\Models\MenuLink;
use App\Models\Post;
use App\Models\Taxonomy;
use App\Supports\Traits\DeleteMenuLinkTrait;
use Illuminate\Support\Facades\DB;

class DeletePostAction
{
    use DeleteMenuLinkTrait;

    public function execute(Post $post, $locale)
    {
        $this->locale = $locale;

        $this->model = $post;

        DB::beginTransaction();
        try {
            $this->model->deleteTranslations($locale);

            if ($this->model->menuLinks->count() !== 0) {
                $this->deleteMenuLinks();
                MenuLink::fixTree();
            }

            if ($this->model->translations->count() == 0) {
                $this->model->delete();
            }
            DB::commit();
        } catch (\HttpException $exception) {
            DB::rollBack();
            throw new $exception;
        }
    }
}
