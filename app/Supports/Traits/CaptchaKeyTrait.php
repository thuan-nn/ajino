<?php

namespace App\Supports\Traits;

use App\Enums\CaptchaKeyEnum;
use App\Models\Setting;

trait CaptchaKeyTrait
{
    /**
     * @return array
     */
    public function captchaKey()
    {
        return Setting::query()
                      ->whereIn('key', [CaptchaKeyEnum::CAPTCHA_SITE_KEY, CaptchaKeyEnum::IS_USED_CAPTCHA])
                      ->pluck('value', 'key')->toArray();
    }
}
