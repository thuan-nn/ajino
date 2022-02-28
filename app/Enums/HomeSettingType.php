<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * Class HomeFeaturedType
 *
 * @package App\Enums
 */
final class HomeSettingType extends Enum
{
    const HOME_FEATURED_CONTENT = 'home_featured_content';

    const HOME_FEATURED_POST = 'home_featured_post';

    const LOGO = 'logo';

    const SLOGAN = 'slogan';

    const GLOBAL_LINKS = 'global_links';

    const JP_LINKS = 'jp_links';

    const SOCIAL_NETWORK = 'social_network';

    const COPYRIGHT = 'copyright';

    const FAVICON = 'favicon';

    const WEB_LINKED = 'web_linked';

    const HYPER_LINKED = 'hyper_linked';

    const STORY = 'story';

    const NOTICE = 'notice';

    const GENERALJSSETTING = 'generalJsSetting';

    const POPUP = 'popup';

    const ADVERTISE = 'advertise';

    const ADVERTISE_IMAGE_PC = 'advertise_image_pc';

    const ADVERTISE_IMAGE_MOBILE = 'advertise_image_mobile';

    const ADVERTISE_IMAGE_SMALL = 'advertise_image_small';
}
