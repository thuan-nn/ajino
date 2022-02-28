<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class VisitorFileType extends Enum
{
    const MORNING = 'morning';

    const AFTERNOON = 'afternoon';

    const SPECIAL_MORNING = 'special-morning';

    const SPECIAL_AFTERNOON = 'special-afternoon';

    const INFO_VISITORS = 'info-visitors';
}
