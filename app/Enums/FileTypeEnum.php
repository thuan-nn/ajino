<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * Class FileTypeEnum
 *
 * @package App\Enums
 */
final class FileTypeEnum extends Enum
{
    const COVER = 'cover';

    const THUMBNAIL = 'thumbnail';

    const CV = 'cv';

    const AVATAR = 'avatar';

    const VISITOR = 'visitor';

    const CAREER = 'career';

    const CONTACT = 'contact';

    const POST = 'post';
}
