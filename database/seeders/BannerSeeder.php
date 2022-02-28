<?php

namespace Database\Seeders;

use App\Enums\BannerType;
use App\Enums\LanguageEnum;
use App\Models\Banner;
use App\Models\BannerItem;
use App\Models\BannerItemTranslation;
use App\Models\BannerTranslation;
use Illuminate\Database\Seeder;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Banner::factory()->count(5)->create();

        $banners = Banner::query();

        $banners->eachById(function ($banner) {
            $bannerItem = BannerItem::factory()->create(['banner_id' => $banner->id]);

            foreach (LanguageEnum::asArray() as $lang) {
                /** @var BannerTranslation $bannerTranslation */
                $this->runItemTranslation(BannerItemTranslation::class, ['banner_item_id' => $bannerItem->id], $lang);
                $this->runTranslation(BannerTranslation::class, ['banner_id' => $banner->id], $lang);
            }
        });
    }

    /**
     * @param mixed $modelTranslation
     * @param array $arraySeed
     * @param $lang
     */
    public function runItemTranslation($modelTranslation, $arraySeed, $lang)
    {
        $ItemTranslation = $modelTranslation::factory()->make($arraySeed);
        $ItemTranslation->additional = (object) [
            'is_home' => rand(0, 1),
        ];

        if ($ItemTranslation->type === BannerType::IMAGE) {
            $ItemTranslation->url = 'https://www.google.com/';
        } else {
            $ItemTranslation->video_url = 'https://www.youtube.com/watch?v=eg4Fz-ytrQs';
        }

        $ItemTranslation->locale = strtolower($lang);

        $ItemTranslation->save();
    }

    /**
     * @param mixed $modelTranslation
     * @param array $arraySeed
     * @param $lang
     */
    public function runTranslation($modelTranslation, $arraySeed, $lang)
    {
        $ItemTranslation = $modelTranslation::factory()->make($arraySeed);
        $ItemTranslation->additional = (object) [
            'is_home' => rand(0, 1),
        ];
        $ItemTranslation->locale = strtolower($lang);
        $ItemTranslation->save();
    }
}
