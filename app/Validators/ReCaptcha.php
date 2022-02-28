<?php

namespace App\Validators;

use App\Enums\CaptchaKeyEnum;
use App\Models\Setting;
use GuzzleHttp\Client;
use Illuminate\Support\Arr;

class ReCaptcha
{
    public function validate($attribute, $value, $parameters, $validator)
    {
        $captchaKey = Setting::query()
                             ->whereIn('key', [CaptchaKeyEnum::CAPTCHA_SECRET_KEY, CaptchaKeyEnum::IS_USED_CAPTCHA])
                             ->pluck('value', 'key')->toArray();

        $captchaSecretKey = Arr::get($captchaKey, 'captcha_secret_key');
        $isUsedCaptcha = (boolean) Arr::get($captchaKey, 'is_used_captcha');

        if (is_null($captchaSecretKey) || $isUsedCaptcha === 0) {
            return false;
        }

        $client = new Client();

        $response = $client->post(
            'https://www.google.com/recaptcha/api/siteverify',
            [
                'form_params' =>
                    [
                        'secret'   => config('app.GOOGLE_RECAPTCHA_SECRET'),
                        'response' => $value,
                    ],
            ]
        );
        $body = json_decode((string) $response->getBody());

        return $body->success;
    }
}