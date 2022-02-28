<?php

namespace App\Actions;

use App\Models\Taxonomy;
use App\Supports\Traits\HandleTranslations;
use Illuminate\Support\Facades\DB;

class UpdateTaxonomyAction
{
    use HandleTranslations;

    /**
     * @param array $data
     * @param Taxonomy $taxonomy
     *
     * @param string $locale
     * @throws \Throwable
     */
    public function execute(array $data, Taxonomy $taxonomy, string $locale)
    {
        $taxonomyData = $this->handleData($data, $locale, $taxonomy);

        DB::beginTransaction();
        try {
            $taxonomy->update($taxonomyData);

            $this->attachFiles($taxonomy, $data, $locale);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new $exception;
        }
    }
}
