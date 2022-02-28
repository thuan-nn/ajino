<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * Class ModelTypeEnum
 *
 * @package App\Enums
 */
final class ModelTypeEnum extends Enum
{
    const POSTTRANSLATION = 'PostTranslation';

    const MENULINKTRANSLATION = 'MenulinkTranslation';

    const BANNERCONTENTTRANSLATION = 'BannerContentTranslation';

    const TAXONOMYTRANSLATION = 'TaxonomyTranslation';
}
