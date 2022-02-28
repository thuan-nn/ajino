<?php

namespace App\Http\Controllers\WEB;

use App\Enums\TemplateEnum;
use App\Models\Post;
use App\Models\PostTranslation;
use App\ViewModels\ProductTaxonomyViewModel;
use App\ViewModels\TaxonomyVerticalViewModel;
use App\ViewModels\UmamiVideoViewModel;

class TaxonamyController extends BaseWebController
{
    /**
     * @param $locale
     * @param \App\Models\PostTranslation $post
     * @param $taxonomy
     * @return \Spatie\ViewModels\ViewModel
     */
    public function show($locale, PostTranslation $post, $taxonomy)
    {
        $post_taxonomy = $this->getTaxonomyBySlug($taxonomy);

        $currentPage = $post_taxonomy->page;
        $template = 'taxonomy_page';

        // check if template is Umami Video
        if ($currentPage === TemplateEnum::UMAMI &&
            isset($post_taxonomy->additional['is_video_layout']) &&
            $post_taxonomy->additional['is_video_layout']) {
            $template = 'umami_video';

            return (new UmamiVideoViewModel($this->globalData, $post_taxonomy, $post_taxonomy->id))->view('web.template.'.$template);
        }

        if ($currentPage === TemplateEnum::PRODUCT) {
            $template = 'product_taxonomy';

            $additional = $post_taxonomy->additional;

            $page = null;
            if (isset($additional['page']) && $additional['page']) {
                $page = Post::query()->find($additional['page']);
            }

            return (new ProductTaxonomyViewModel($this->globalData, $post_taxonomy, $page))->view('web.template.'.$template);
        }

        return (new TaxonomyVerticalViewModel($this->globalData, $post, $post_taxonomy->id))->view('web.template.'.$template);
    }
}
