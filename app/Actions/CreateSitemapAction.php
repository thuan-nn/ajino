<?php

namespace App\Actions;

use App\Enums\PostTypeEnum;
use App\Enums\TaxonomyEnum;
use App\Models\Job;
use App\Models\Post;
use App\Models\Taxonomy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;

class CreateSitemapAction
{
    private array $sitemapName = [];

    public function generate()
    {
        $this->generatePostTable();
        $this->generateTaxonomyTable();
        $this->generateJobTable();

        // Generate and write to public folder
        $sitemapIndex = App::make("sitemap");

        foreach ($this->sitemapName as $name) {
            $sitemapIndex->addSitemap(URL::to("sitemap/$name.xml"));
        }

        $sitemapIndex->store('sitemapindex', 'sitemap');
    }

    /**
     * read Post table
     */
    private function generatePostTable()
    {
        $postType = PostTypeEnum::asArray();
        foreach ($postType as $type) {
            $this->execute(
                new Post,
                ['type' => $type],
                'posts.post.show',
                'post',
                'getSlugWithParent',
                ['id', 'type'],
                'post_'.$type
            );
        }
    }

    /**
     * read Taxonomy table
     */
    private function generateTaxonomyTable()
    {
        $taxonomyType = TaxonomyEnum::asArray();
        foreach ($taxonomyType as $type) {
            $this->execute(
                new Taxonomy,
                ['type' => $type],
                'taxonomy.show',
                'taxonomy',
                'getSlug',
                ['id'],
                'category_'.$type
            );
        }
    }

    /**
     * read Job table
     */
    private function generateJobTable()
    {
        $this->execute(
            new Job,
            [],
            'job.show',
            'job',
            'getSlug',
            ['id'],
            'job'
        );
    }

    /**
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param array $where
     * @param $routeName
     * @param $routeKey
     * @param string $functionSlug
     * @param array $select
     * @param string $siteMapName
     */
    private function execute(
        Model $model,
        $where,
        $routeName,
        $routeKey,
        $functionSlug,
        $select = ['id'],
        $siteMapName = 'sitemap'
    ) {
        $sitemap = App::make('sitemap');

        // add to sitemap Index
        $this->sitemapName[] = $siteMapName;

        $model->query()
              ->select($select)
              ->where('is_published', 1)
              ->when($where, function ($query) use ($where) {
                  /** @var \Illuminate\Database\Eloquent\Builder $query */
                  return $query->where($where);
              })
              ->chunk(100, function ($items) use ($routeName, $functionSlug, $routeKey, $sitemap) {
                  foreach ($items as $item) {
                      // get translation
                      $translations = $item->translations()
                                           ->select('slug', 'locale', 'updated_at', 'created_at')
                                           ->get();

                      foreach ($translations as $translation) {
                          $slug = $this->{$functionSlug}($translation);

                          if ($slug) {
                              $routeUI['locale'] = $translation->locale;
                              $routeUI[$routeKey] = $slug;

                              $slugRoute = route_ui($routeName, $routeUI);

                              $sitemap->add(
                                  $slugRoute,
                                  $translation->updated_at ?: $translation->created_at,
                                  '0.8',
                                  'monthly'
                              );
                          }
                      }
                  }
              });

        $sitemap->store('xml', 'sitemap/'.$siteMapName);
    }

    /**
     * @param $post
     * @return string|null
     */
    private function getSlugWithParent($post)
    {
        $parent = isset($post->post->parent) ? $post->post->parent : null;
        if ($parent) {
            return $this->getSlugWithParent($parent)."/".$post->slug;
        }

        return $post ? $post->slug : null;
    }

    /**
     * @param $taxonomy
     * @return string|null
     */
    private function getSlug($taxonomy)
    {
        return $taxonomy->slug ?: null;
    }
}