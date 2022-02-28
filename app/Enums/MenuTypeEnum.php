<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * Class MenuTypeEnum
 *
 * @package App\Enums
 */
final class MenuTypeEnum extends Enum
{
    const MAIN_LEFT = 'main_left';

    const MAIN_RIGHT = 'main_right';

    const FOOTER_TOP_LEFT = 'footer_top_left';

    const FOOTER_TOP_RIGHT = 'footer_top_right';

    const FOOTER_TOP_MIDDLE = 'footer_top_middle';

    const FOOTER_BOTTOM = 'footer_bottom';
}
