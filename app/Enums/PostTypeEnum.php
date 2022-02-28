<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * Class PostTypeEnum
 *
 * @package App\Enums
 */
final class PostTypeEnum extends Enum
{
    const STORY_GROUP = 'story_group';

    const PRODUCT = 'product';

    const UMAMI = 'umami';

    const CAREER = 'career';

    const NEWS = 'news';

    const FS_PRODUCT = 'fs_product';

    const STORY_VN = 'story_vn';

    const PAGE = 'page';
}
