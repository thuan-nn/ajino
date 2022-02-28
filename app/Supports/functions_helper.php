<?php

use Illuminate\Support\Collection;

if (! function_exists('urlReplaceLocale')) {
    /**
     * @param $currentLocale
     * @param $locale
     * @return string
     */
    function urlReplaceLocale($currentLocale, $locale)
    {
        $url = url()->full();

        return \Illuminate\Support\Str::replaceFirst('/'.$currentLocale, '/'.$locale, $url);
    }
}

if (! function_exists('thumbnail')) {
    /**
     * Generate the URL to a named route.
     *
     * @param array|string $name
     * @param mixed $parameters
     * @param bool $absolute
     * @return string
     */
    function route_ui($name, $parameters = [], $absolute = true)
    {
        return app('url')->route('ui.'.$name, $parameters, $absolute);
    }
}

if (! function_exists('thumbnail')) {

    function thumbnail($fileIds, $type = null)
    {
        $files = \App\Models\File::query()->find($fileIds);

        if (is_null($files)) {
            return [];
        }

        $thumbnail = collect($files->reduce(function ($list, $file) use ($type) {
            if (($type && $file->type !== $type) || (! $type && $file->type === 'post')) {
                return $list;
            }
            $list[] = [
                'id'   => $file->id,
                'url'  => $file->url,
                'type' => $file->type,
                'size' => $file->size,
                'name' => $file->name_file,
            ];

            return $list;
        }, []));

        return (object) $thumbnail;
    }
}

if (! function_exists('getImagePath')) {
    /**
     * @param mixed $model
     * @param $type
     * @return string
     */
    function getImagePath($model, $type)
    {
        if (! $model) {
            return null;
        }

        $locale = app()->getLocale();
        $model_translation = $model->translate($locale);
        if ($model_translation) {
            $image = $model_translation->files->where('is_published', 1)->where('type', $type)->first();

            if ($image) {
                $path = array_values(explode('/', $image->path));

                if (array_shift($path) === 'uploads') {
                    return asset('storage/'.$image->path);
                } else {
                    return asset($image->path);
                }
            }
        }

        return '#';
    }
}

if (! function_exists('getImageUrl')) {
    /**
     * @param $model
     * @param $type
     * @return mixed
     */
    function getImagePathFromCollection($model, $type)
    {
        if (! $model['images'] && ! $model['images'] instanceof Collection) {
            return null;
        }

        if (is_array($model['images'])) {
            $model['images'] = collect($model['images']);
        }

        /** @var \Illuminate\Support\Collection $model ['images'] */
        $image = $model['images']->where('type', $type)->first();

        return $image ? $image['url'] : '';
    }
}

if (! function_exists('getImageUrl')) {
    /**
     * @param mixed $model
     * @param $type
     * @return string
     */
    function getImageUrl($model, $type)
    {
        if (! $translation = $model->translation) {
            return null;
        }

        /** @var \Illuminate\Support\Collection $translation */
        $image = optional($translation->files)->where('type', $type)->first();

        if (! $image) {
            return null;
        }

        return $image['url'];
    }
}

function getFileTypeCover()
{
    return \App\Enums\FileTypeEnum::COVER;
}

function getFileTypeThumbnail()
{
    return \App\Enums\FileTypeEnum::THUMBNAIL;
}

/**
 * @param $model
 * @param $key
 * @return mixed
 */
function getLang($model, $key)
{
    $locale = app()->getLocale();

    return optional($model->translate($locale))->{$key};
}

if (! function_exists('getUrlMenuLinks')) {
    /**
     * @param $menuLink
     * @return string
     */
    function getUrlMenuLinks($menuLink)
    {
        $locale = app()->getLocale();

        if (isset($menuLink->taxonomy) && $taxonomy = $menuLink->taxonomy) {
            if ($slug = getPostSlug($taxonomy)) {
                return $menuLink = route_ui('taxonomy.show', [
                    'locale'   => $locale,
                    'taxonomy' => $slug,
                ]);
            }
        }

        if (isset($menuLink->post) && $post = $menuLink->post) {
            if ($slug = getPostSlug($post)) {
                return $menuLink = route_ui('posts.post.show', [
                    'locale' => $locale,
                    'post'   => $slug,
                ]);
            }
        }

        return $menuLink = $menuLink->{'url:'.$locale};
    }
}

if (! function_exists('getImageSetting')) {
    function getImageSetting($item)
    {
        if (! $image = \Illuminate\Support\Arr::get($item, 'image')) {
            return null;
        }

        return optional(\Illuminate\Support\Arr::first($image))['url'];
    }
}

if (! function_exists('getImageAdvertise')) {
    function getImageAdvertise($item)
    {
        return optional(\Illuminate\Support\Arr::first($item))['url'];
    }
}

if (! function_exists('checkDisplayBanner')) {
    function checkDisplayBanner($item)
    {
        if (!$item) {
            return false;
        }

        $bannerPC = \Illuminate\Support\Arr::get($item, 'advertise_image_pc.'.app()->getLocale());
        $bannerSmall = \Illuminate\Support\Arr::get($item, 'advertise_image_small.'.app()->getLocale());
        $bannerMobile = \Illuminate\Support\Arr::get($item, 'advertise_image_mobile.'.app()->getLocale());

        $bannerPublished = \Illuminate\Support\Arr::get($item, 'advertise.is_published');

        return $bannerPC && $bannerSmall && $bannerMobile && $bannerPublished;
    }
}

if (! function_exists('getUrlBanner')) {
    function getUrlBanner($banner)
    {
        $locale = app()->getLocale();

        if ($banner->{'url:'.$locale} === \App\Enums\BannerType::IMAGE) {
            return $banner->{'url:'.$locale};
        }

        return $banner->{'video_url:'.$locale};
    }
}

if (! function_exists('getPostSlug')) {
    /**
     * @param mixed $post
     * @return string
     */
    function getPostSlug($post)
    {
        $locale = app()->getLocale();

        if (isset($post->parent)) {
            $parent = $post->parent;

            return getPostSlug($parent)."/".$post->{'slug:'.$locale};
        }

        if ($post instanceof \App\Models\Post && isset($post->type) && $post->type !== \App\Enums\PostTypeEnum::PAGE) {
            if ($post->type === \App\Enums\PostTypeEnum::UMAMI) {
                $taxonomy = $post->taxonomies()->first();

                $pageId = \Illuminate\Support\Arr::get($taxonomy->additional, 'page');

                $page = \App\Models\Post::find($pageId);
            } else {
                $page = \App\Models\Post::query()
                                        ->translatedIn($locale)
                                        ->whereTranslation('additional->template', $post->type)
                                        ->first();
            }

            return getPostSlug($page)."/".$post->{'slug:'.$locale};
        }

        return $post ? $post->{'slug:'.$locale} : null;
    }
}

if (! function_exists('checkDateFromTo')) {
    /**
     * @param $from
     * @param $to
     * @return bool
     */
    function checkDateFromTo($from, $to)
    {
        $now = \Carbon\Carbon::parse(now());
        $from = \Carbon\Carbon::parse($from);
        $to = \Carbon\Carbon::parse($to);

        return $now->gte($from->startOfDay()) && $now->lte($to->endOfDay());
    }
}

if (! function_exists('renderHtmlPreTag')) {
    /**
     * @param $string
     * @return string|string[]
     */
    function renderHtmlPreTag($string)
    {
        $string_replaced = str_replace([
            '<pre class="ql-syntax" spellcheck="false">',
            '</pre>',
        ], '', html_entity_decode($string));

        return html_entity_decode(trim($string_replaced));
    }

    if (! function_exists('getFilePath')) {
        /**
         * @param mixed $model
         * @param $type
         * @param string $local
         * @return string
         */
        function getFilePath($model, $type, $local = \App\Enums\LanguageEnum::VI)
        {
            if (! count($model->toArray())) {
                return null;
            }
            if (! $translations = $model->translate($local)) {
                return null;
            }

            /** @var \Illuminate\Support\Collection $translation */
            $files = optional($translations->files())->where('type', $type)->get();

            if (! $files) {
                return null;
            }

            return $files->map(function ($file) {
                $filePath = '';
                $path = array_values(explode('/', $file->path));
                if (array_shift($path) === 'uploads') {
                    $filePath = asset('storage/'.$file->path);
                } else {
                    $filePath = asset($file->path);
                }

                return [
                    'name' => $file->name_file,
                    'url'  => $filePath,
                ];
            });
        }
    }
}

if (! function_exists('stripVN')) {
    function stripVN($str)
    {
        $str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", 'a', $str);
        $str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", 'e', $str);
        $str = preg_replace("/(ì|í|ị|ỉ|ĩ)/", 'i', $str);
        $str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", 'o', $str);
        $str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", 'u', $str);
        $str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", 'y', $str);
        $str = preg_replace("/(đ)/", 'd', $str);

        $str = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", 'A', $str);
        $str = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", 'E', $str);
        $str = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", 'I', $str);
        $str = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", 'O', $str);
        $str = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", 'U', $str);
        $str = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", 'Y', $str);
        $str = preg_replace("/(Đ)/", 'D', $str);

        return $str;
    }
}
