<?php

namespace App\Supports\Traits;

use App\Enums\CaptchaKeyEnum;
use Illuminate\Support\Arr;

trait GoogleCaptchaCheker
{
    /**
     * verify reCaptcha from Google Recaptcha v3
     *
     * @param string $captcha
     * @param $settingCaptcha
     * @return bool
     */
    function verifyReCaptcha($settingCaptcha, $captcha = null)
    {
        if (! $captcha) {
            return false;
        }

        $secretKey_GoogleCaptcha = Arr::get($settingCaptcha, CaptchaKeyEnum::CAPTCHA_SECRET_KEY);

        // post request to server
        $url = 'https://www.google.com/recaptcha/api/siteverify';
        $data = ['secret' => $secretKey_GoogleCaptcha, 'response' => $captcha];

        $options = [
            'http' => [
                'header'  => "Content-type: application/x-www-form-urlencoded",
                'method'  => 'POST',
                'content' => http_build_query($data),
            ],
            'ssl' => [
                'verify_peer'      => false,
                'verify_peer_name' => false,
            ],
        ];

        $context = stream_context_create($options);
        $response = file_get_contents($url, false, $context);
        $responseKeys = json_decode($response, true);
        header('Content-type: application/json');

        if ($responseKeys["success"]) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param $settingCaptcha
     * @return boolean
     */
    public function checkUsedCaptCha($settingCaptcha)
    {
        return Arr::get($settingCaptcha, CaptchaKeyEnum::IS_USED_CAPTCHA);
    }

    /**
     * @param $request
     * @param $settingCaptCha
     * @return bool
     */
    public function checkMatchWithCaptcha($request, $settingCaptCha): bool
    {
        if ((boolean) $this->checkUsedCaptCha($settingCaptCha)) {
            // Check Match with reCaptcha
            return $this->verifyReCaptcha($settingCaptCha, $request->get('token_captcha'));
        }

        return true;
    }
}
