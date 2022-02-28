<?php

namespace Database\Seeders;

use App\Enums\HomeSettingType;
use App\Enums\LanguageEnum;
use App\Models\File;
use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (HomeSettingType::asArray() as $key => $value) {
            switch ($value) {
                case HomeSettingType::HOME_FEATURED_CONTENT:
                case HomeSettingType::HOME_FEATURED_POST:
                case HomeSettingType::WEB_LINKED:
                    $data = [];
                    break;
                case HomeSettingType::LOGO:
                    $logo = File::query()->whereJsonContains('additional->type', HomeSettingType::LOGO)->first();
                    if ($logo) {
                        $data = $logo->path;
                    } else {
                        $data = '';
                    }
                    break;
                case HomeSettingType::SLOGAN:
                    $data = (object) [
                        LanguageEnum::VI => 'Công ty Ajinomoto Việt Nam',
                        LanguageEnum::EN => 'Ajinomoto Vietnam',
                    ];
                    break;
                case HomeSettingType::COPYRIGHT:
                    $data = (object) [
                        LanguageEnum::VI => '© 2019 - 2020 Ajinomoto Co., Inc.',
                        LanguageEnum::EN => '© 2019 - 2020 Ajinomoto Co., Inc.',
                    ];
                    break;
                case HomeSettingType::SOCIAL_NETWORK:
                    $data = (object) [
                        'facebook'  => '',
                        'pinterest' => '',
                        'instagram' => '',
                        'linkedin'  => '',
                        'youtube'   => '',
                    ];
                    break;
                case HomeSettingType::GLOBAL_LINKS:
                    $data = [
                        'link'        => 'https://www.ajinomoto.com',
                        'translation' => [
                            LanguageEnum::VI => 'Tập đoàn Ajinomoto',
                            LanguageEnum::EN => 'Ajinomoto Global Group',
                        ],
                    ];
                    break;
                case HomeSettingType::NOTICE:
                case HomeSettingType::STORY:
                    $data = [
                        LanguageEnum::VI => [
                            'title'   => '',
                            'content' => '',
                        ],
                        LanguageEnum::EN => [
                            'title'   => '',
                            'content' => '',
                        ],
                    ];
                    break;
                case HomeSettingType::JP_LINKS:
                    $data = 'https://www.ajinomoto.co.jp';
                    break;
                case HomeSettingType::FAVICON:
                    $favicon = File::query()->whereJsonContains('additional->type', HomeSettingType::FAVICON)->first();
                    if ($favicon) {
                        $data = $favicon->path;
                    } else {
                        $data = '';
                    }
                    break;
                default:
                    $data = '';
            }

            Setting::firstOrCreate(
                ['key' => $value],
                ['value' => $data]
            );
        }

        Setting::firstOrCreate(
            ['key' => 'email'],
            ['value' => ["admin" => "phamthinh1791998@gmail.com", "hr" => "phamthinh1791998@gmail.com"]]
        );
    }
}
