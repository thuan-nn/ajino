<?php

namespace App\Actions;

use App\Models\Taxonomy;
use App\Supports\Traits\HandleTranslations;
use Illuminate\Support\Facades\DB;

class CreateTaxonomyAction
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
        $taxonomy = new Taxonomy();
        $taxonomyData = $this->handleData($data, $locale, $taxonomy);
        
        DB::beginTransaction();
        try {
            $taxonomy = $taxonomy->create($taxonomyData);

            $this->attachFiles($taxonomy, $data, $locale);
            DB::commit();
        } catch (\HttpException $httpException) {
            DB::rollBack();
            throw new $httpException->getMessage();
        }

        return $taxonomy;
    }
}
