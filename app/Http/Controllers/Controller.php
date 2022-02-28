<?php

namespace App\Http\Controllers;

use App\Models\PostTranslation;
use App\Models\Taxonomy;
use App\Supports\Traits\HasTransformer;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, HasTransformer;

    /**
     * @var int $perPage
     */
    protected $perPage;

    /**
     * @var string $locale
     */
    protected $locale;

    /**
     * Controller constructor.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function __construct(Request $request)
    {
        $this->perPage = (int) $request->get('perPage', 15);

        $this->locale = $request->get('locale') ?? $request->header('App-Locale');
    }

    /**
     * @param $locale
     * @param $slug
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    public function getPostBySlug($locale, $slug)
    {
        return PostTranslation::query()
                              ->where('slug', $slug)
                              ->where('locale', $locale)
                              ->first();
    }

    /**
     * @param $slug
     * @return mixed
     */
    public function getTaxonomyBySlug($slug)
    {
        return Taxonomy::query()
                       ->translatedIn($this->locale)
                       ->whereTranslation('slug', $slug)
                       ->first();
    }
}
