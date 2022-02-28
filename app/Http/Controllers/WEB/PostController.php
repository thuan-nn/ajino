<?php

namespace App\Http\Controllers\WEB;

use App\Enums\PostTypeEnum;
use App\Enums\TemplateEnum;
use App\Models\Post;
use App\ViewModels\BaseViewModel;
use App\ViewModels\JobDetailViewModel;
use App\ViewModels\PostDetailViewModel;
use App\ViewModels\SearchPostViewModel;
use App\ViewModels\StaticPageViewModel;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class PostController extends BaseWebController
{
    /**
     * @param $model
     * @param Post $postParent
     * @return array
     */
    public function template($model, $postParent = null)
    {
        $template = Arr::get($model->additional, 'template');
        $postType = $model ? $model->type : null;
        $view = null;
        $viewModel = null;

        switch (true) {
            case $postType !== PostTypeEnum::PAGE:
                $view = 'post_detail';
                $viewModel = new PostDetailViewModel($this->globalData, $model, $postParent);
                break;
            case $template:
                $view = $template;
                $className = 'App\\ViewModels\\'.str_replace('_', '', Str::title($template)).'ViewModel';
                $viewModel = new $className($this->globalData, $model, $postParent);
                break;
            default:
                $view = TemplateEnum::STATIC_PAGE;
                $viewModel = new StaticPageViewModel($this->globalData, $model, $postParent);
        }

        return [
            'view'      => 'web.template.'.$view,
            'viewModel' => $viewModel,
        ];
    }

    /**
     * @param $locale
     * @param $post
     * @return mixed
     */
    public function show($locale, $post)
    {
        $slugs = explode('/', $post);
        $lastSlug = array_pop($slugs);

        //$post = $this->getPostBySlug($locale, $lastSlug);

        $currentPost = $this->getPostBySlugTranslation($locale, $lastSlug);

        if (! isset($currentPost)) {
            $languagePost = Post::query()
                                ->with('parent')
                                ->whereTranslation('slug', $lastSlug)
                                ->first();

            if (isset($languagePost)) {
                $translation = Arr::first($languagePost->translations);

                return redirect(route_ui('posts.post.show', [
                    'locale' => $translation->locale,
                    'post'   => $translation->slug,
                ]));
            }

            return (new BaseViewModel($this->globalData))->view('web.page.404_page');
        }

        if (count($slugs) === 0) {
            $template = $this->template($currentPost, $currentPost);
        } else {
            $parentSlug = array_pop($slugs);
            if ($parentSlug === 'job') {
                return (new JobDetailViewModel($this->globalData, $currentPost, $lastSlug))->view('web.template.job_detail');
            }

            $postParent = $currentPost->parent ?: null;
            $template = $this->template($currentPost, $postParent);
        }

        return ($template['viewModel'])->view($template['view']);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param $locale
     * @param $post
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function filterPost(Request $request, $locale, $post)
    {
        $postCureent = $this->getPostBySlugTranslation($locale, $post);
        $taxonomy = $this->getTaxonomyBySlug($request->slug);
        $postType = $request->postType;
        $postPage = $request->postPage;
        $posts = $this->getPosts($taxonomy, $postType, $postPage);

        $data = [
            'postChildren' => $posts,
            'locale'       => $this->locale,
            'title'        => optional($postCureent)->title,
        ];

        return view('web.component.product-category', $data);
    }

    /**
     * @param $locale
     * @param \Illuminate\Http\Request $request
     * @return \Spatie\ViewModels\ViewModel
     */
    public function searchPost($locale, Request $request)
    {
        return (new SearchPostViewModel($this->globalData, $request->all()))->view('web.page.search_post');
    }

    /**
     * @param \App\Models\Taxonomy $taxonomy
     * @param null $postType
     * @param null $orderBy
     * @param null $postPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    private function getPosts($taxonomy, $postType = null, $postPage = null, $orderBy = 'updated_at')
    {
        $postQuery = Post::query()
                         ->where('is_published', 1)
                         ->when($postPage, function ($query) use ($postPage) {
                             return $query->whereType($postPage);
                         })
                         ->with('translations.files')
                         ->whereHas('taxonomies', function ($query) use ($taxonomy, $postPage, $postType) {
                             /** @var \Illuminate\Database\Eloquent\Builder $query */
                             return $query->when($taxonomy, function ($query) use ($taxonomy) {
                                 /** @var \Illuminate\Database\Eloquent\Builder $query */
                                 return $query->where('id', $taxonomy->id);
                             })
                                          ->whereType($postType)
                                          ->wherePage($postPage);
                         })
                         ->latest($orderBy);

        return $postQuery->paginate($this->perPage)->appends(request()->except('page'));
    }
}
