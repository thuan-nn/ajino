<?php

namespace App\Http\Controllers\WEB;

use App\Enums\HomeSettingType;
use App\Enums\LanguageEnum;
use App\Models\MenuLink;
use App\Models\Post;
use App\Models\PostTranslation;
use App\Models\Setting;
use App\Models\Taxonomy;
use App\Supports\Traits\HasTransformer;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\App;

class BaseWebController extends BaseController
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
     * get all global data for ViewModel
     *
     * @var null
     */
    protected $globalData = [];

    /**
     * Controller constructor.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function __construct(Request $request)
    {
        $this->perPage = (int) $request->get('perPage', 15);

        $this->locale = $request->segment(1) ?: (App::getLocale() ?: LanguageEnum::VI);

        // get all setting
        $this->globalData['settingData'] = $this->getSettingData();

        // get all menu
        $this->globalData['menus'] = $this->getMenu();
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
     * @param $locale
     * @param $slug
     * @return mixed
     */
    public function getPostBySlugTranslation($locale, $slug)
    {
        return Post::query()
                   ->with('parent')
                   ->whereTranslation('slug', $slug)
                   ->whereTranslation('locale', $this->locale)
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

    /**
     * Get setting data
     *
     * @return mixed
     */
    public function getSettingData()
    {
        if (isset($this->globalData['settingData']) && $this->globalData['settingData']) {
            return $this->globalData['settingData'];
        }

        $settingKeys = array_values(array_merge(HomeSettingType::asArray(), ['web_linked']));

        return $this->getSettingValue($settingKeys)->mapWithKeys(function ($item) {
            return [
                $item->key => $item->value,
            ];
        });
    }

    /**
     * Fetch setting data from DB by array keys
     *
     * @param array $keys
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getSettingValue(array $keys)
    {
        return Setting::query()->whereIn('key', $keys)->get();
    }

    /**
     * @return mixed
     */
    public function getMenu()
    {
        return MenuLink::query()
                       ->with(['menu', 'children'])
                       ->whereHas('translations', function ($query) {
                           /** @var \Illuminate\Database\Eloquent\Builder $query */
                           return $query->where('locale', $this->locale);
                       })
                       ->with('post', function ($query) {
                           /** @var \Illuminate\Database\Eloquent\Builder $query */
                           return $query->with(['translation', 'parent']);
                       })
                       ->orderBy('order', 'asc')
                       ->get()
                       ->toTree();
    }
}
