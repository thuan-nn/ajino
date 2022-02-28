<?php

namespace App\Supports\Traits;

use App\Models\Job;
use App\Models\Post;

trait BreadcrumbTrait
{
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
        foreach ($segments as $segment) {
            $post = Post::query()->whereTranslation('slug', $segment)->first();

            if (! $post) {
                $job = Job::query()->whereTranslation('slug', $segment)->first();

                if ($job) {
                    $data = [
                        'title' => $job->{'title:'.$this->locale},
                        'route' => url()->current(),
                    ];
                }
            }

            // check if belong to Taxonomy
            if ($post && $postTaxonomy = optional($post->taxonomies())) {
                $taxonomy = $postTaxonomy->where('type', '!=', 'tag')->first();

                if ($taxonomy) {
                    $data = [
                        'title' => $taxonomy->{'title:'.$this->locale},
                        'route' => route_ui('taxonomy.show', [
                            'locale'   => $this->locale,
                            'taxonomy' => $taxonomy->{'slug:'.$this->locale},
                        ]),
                    ];

                    array_push($breadcrumbs, $data);
                }
            }

            if ($post) {
                $data = [
                    'title' => $post->{'title:'.$this->locale},
                    'route' => route_ui('posts.post.show', [
                        'locale' => $this->locale,
                        'post'   => $this->getPostSlug($post),
                    ]),
                ];
            }

            if (isset($data) && $data) {
                array_push($breadcrumbs, $data);
            }
        }

        $home = ['title' => trans('languages.HOME'), 'route' => route_ui('home', $this->locale)];
        array_unshift($breadcrumbs, $home);

        return $breadcrumbs;
    }

    /**
     * @param \App\Models\Post $post
     * @return mixed|string
     */
    public function getPostSlug(Post $post)
    {
        if (! is_null(optional($post)->parent_id)) {
            return $this->getPostSlug($post->parent)."/".$post->slug;
        }

        return $post->slug;
    }
}
