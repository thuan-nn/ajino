<?php

namespace Database\Seeders;

use App\Enums\LanguageEnum;
use App\Enums\PageEnum;
use App\Enums\PostTypeEnum;
use App\Enums\TemplateEnum;
use App\Models\File;
use App\Models\Post;
use App\Models\PostTranslation;
use App\Models\Taxonomy;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Post::factory()->count('50')->create();
        $posts = Post::query();

        $posts->eachById(function ($post) {
            foreach (LanguageEnum::asArray() as $lang) {
                $postTranslation = PostTranslation::factory()->make(['post_id' => $post->id]);
                $postTranslation->locale = strtolower($lang);
                $postTranslation->additional = (object) [
                    'template' => strtolower(TemplateEnum::STATIC_PAGE),
                ];
                //if ($post->type === PostTypeEnum::STORY) {
                //    $postTranslation->additional = (object) [
                //        'is_home'  => rand(0, 1),
                //        'template' => strtolower(TemplateEnum::POST_DETAIL),
                //    ];
                //}
                $postTranslation->save();
            }
        });

        $posts->where('type', '<>', PostTypeEnum::PAGE)->get()->map(function ($post) {
            $randomTaxonomies = Taxonomy::inRandomOrder()->take(rand(1, 3))->get();

            return $post->taxonomies()->sync($randomTaxonomies);
        });

        $careerRecruit = $posts->create([
            'type'         => 'page',
            'is_published' => 1,
        ]);
        $fileContentCareerRecruit = file_get_contents(database_path('mocks/career_recruit_process_data.json'));
        $jsonDataCareerRecruit = json_decode(trim($fileContentCareerRecruit, "\xEF\xBB\xBF"), true);
        $file = File::create([
            'name'         => '1610164385_career-recruit-slide-01.png',
            'mime_type'    => 'image/png',
            'is_published' => 1,
            'size'         => '2771244',
            'disk'         => 'public',
            'path'         => 'assets/img/career-recruit-slide-01.png',
            'type'         => 'cover',
        ]);
        foreach (LanguageEnum::asArray() as $lang) {
            $careerRecruitTranslate = PostTranslation::create([
                'post_id'     => $careerRecruit->id,
                'title'       => $jsonDataCareerRecruit[strtolower($lang)]['title'],
                'slug'        => $jsonDataCareerRecruit[strtolower($lang)]['slug'],
                'content'     => $jsonDataCareerRecruit[strtolower($lang)]['content'],
                'description' => $jsonDataCareerRecruit[strtolower($lang)]['description'],
                'locale'      => strtolower($lang),
                'additional'  => (object) [
                    'template' => strtolower(TemplateEnum::STATIC_PAGE),
                ],
            ]);
            $careerRecruitTranslate->files()->sync($file);
        }

        $sitemap = $posts->create([
            'type'         => 'page',
            'is_published' => 1,
        ]);
        $fileContentSitemap = file_get_contents(database_path('mocks/sitemap_data.json'));
        $jsonDataSitemap = json_decode(trim($fileContentSitemap, "\xEF\xBB\xBF"), true);
        foreach (LanguageEnum::asArray() as $lang) {
            PostTranslation::create([
                'post_id'    => $sitemap->id,
                'title'      => $jsonDataSitemap[strtolower($lang)]['title'],
                'slug'       => $jsonDataSitemap[strtolower($lang)]['slug'],
                'locale'     => strtolower($lang),
                'additional' => (object) [
                    'page' => strtolower(PageEnum::SITEMAP),
                ],
            ]);
        }
        $privacy = $posts->create([
            'type'         => 'page',
            'is_published' => 1,
        ]);
        $fileContentPrivacy = file_get_contents(database_path('mocks/privacy_data.json'));
        $jsonDataPrivacy = json_decode(trim($fileContentPrivacy, "\xEF\xBB\xBF"), true);
        foreach (LanguageEnum::asArray() as $lang) {
            PostTranslation::create([
                'post_id'    => $privacy->id,
                'title'      => $jsonDataPrivacy[strtolower($lang)]['title'],
                'slug'       => $jsonDataPrivacy[strtolower($lang)]['slug'],
                'content'    => $jsonDataPrivacy[strtolower($lang)]['content'],
                'locale'     => strtolower($lang),
                'additional' => (object) [
                    'template' => strtolower(TemplateEnum::STATIC_PAGE),
                ],
            ]);
        }
        $contact = $posts->create([
            'type'         => 'page',
            'is_published' => 1,
        ]);
        $fileContentContact = file_get_contents(database_path('mocks/contact_data.json'));
        $jsonDataContact = json_decode(trim($fileContentContact, "\xEF\xBB\xBF"), true);
        foreach (LanguageEnum::asArray() as $lang) {
            PostTranslation::create([
                'post_id'    => $contact->id,
                'title'      => $jsonDataContact[strtolower($lang)]['title'],
                'slug'       => $jsonDataContact[strtolower($lang)]['slug'],
                'content'    => $jsonDataContact[strtolower($lang)]['content'],
                'locale'     => strtolower($lang),
                'additional' => (object) [
                    'page' => strtolower(PageEnum::CONTACT),
                ],
            ]);
        }
    }
}
