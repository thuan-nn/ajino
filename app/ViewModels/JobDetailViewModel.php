<?php

namespace App\ViewModels;

use App\Enums\PostTypeEnum;
use App\Enums\TemplateEnum;
use App\Models\Job;
use App\Models\Post;
use App\Supports\Traits\CaptchaKeyTrait;
use Illuminate\Support\Collection;

class JobDetailViewModel extends BaseViewModel
{
    use CaptchaKeyTrait;

    protected $slugJob;

    protected $jobCurrent;

    public function __construct($globalData, $postCurrent, $slugJob)
    {
        parent::__construct($globalData);

        $this->currentPost = $postCurrent;
        $this->slugJob = $slugJob;
    }

    /**
     * @return array
     */
    public function job()
    {
        $job = Job::query()
                  ->whereTranslation('slug', $this->slugJob)
                  ->with('location')
                  ->first();

        $this->jobCurrent = $job;

        return $this->jobCurrent;
    }

    /**
     * @return \Illuminate\Support\Collection|null
     */
    public function meta()
    {
        $additional = isset($this->jobCurrent->{'additional:'.$this->locale}) ?: null;

        $title = isset($this->jobCurrent->{'title:'.$this->locale}) ? $this->jobCurrent->{'title:'.$this->locale} : '';
        $description = isset($this->jobCurrent->{'description:'.$this->locale}) ? $this->jobCurrent->{'description:'.$this->locale} : '';

        return new Collection([
            'title'       => isset($additional['meta']['title']) && $additional['meta']['title'] ? $additional['meta']['title'] : $title,
            'description' => isset($additional['meta']['description']) && $additional['meta']['description'] ? $additional['meta']['description'] : $description,
        ]);
    }

    /**
     * @param \App\Models\Post $post
     * @return mixed|string
     */
    private function getPostSlug(Post $post)
    {
        if (! is_null(optional($post)->parent_id)) {
            return $this->getPostSlug($post->parent)."/".$post->slug;
        }

        return $post->slug;
    }

    /**
     * Get breadcrumbs
     *
     * @return array
     */
    public function breadcrumbs()
    {
        $segments = array_values(request()->segments());

        array_shift($segments);
        if (in_array('job', $segments)) {
            $segments = array_diff($segments, ['job']);
        }

        if (in_array('search-career', $segments)) {
            return null;
        }

        $breadcrumbs = [];

        /** @var Post $page */
        $page = Post::query()
                    ->where([
                        'is_published' => 1,
                        'type'         => PostTypeEnum::PAGE,
                    ])
                    ->whereTranslation('additional->template', TemplateEnum::CAREER)
                    ->first();

        if ($page) {
            $data = [
                'title' => $page->{'title:'.$this->locale},
                'route' => route_ui('posts.post.show', [
                    'locale' => $this->locale,
                    'post'   => $this->getPostSlug($page),
                ]),
            ];

            array_push($breadcrumbs, $data);
        }

        foreach ($segments as $segment) {
            $job = Job::query()->whereTranslation('slug', $segment)->first();

            $data = [
                'title' => $job->{'title:'.$this->locale},
                'route' => url()->current(),
            ];

            array_push($breadcrumbs, $data);
        }

        $home = ['title' => trans('languages.HOME'), 'route' => route_ui('home', $this->locale)];
        array_unshift($breadcrumbs, $home);

        return $breadcrumbs;
    }
}
