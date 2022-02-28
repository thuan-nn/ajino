<?php

namespace App\Supports\Traits;

trait TransformerTrait
{
    /**
     * @var string $locale
     */
    private $locale;

    /**
     * PostTransformer constructor.
     */
    public function __construct()
    {
        $this->locale = request('locale') ? request('locale') : request()->header('App-Locale');
    }

    /**
     * @param $model
     * @param string $locale
     * @return mixed
     */
    private function checkTranslateRelations($model, string $locale)
    {
        return $model->translate($locale);
    }
}
