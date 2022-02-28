<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class CaptchaKeyEnum extends Enum
{
    const CAPTCHA_SITE_KEY = 'captcha_site_key';

    const CAPTCHA_SECRET_KEY = 'captcha_secret_key';

    const IS_USED_CAPTCHA = 'is_used_captcha';
}
