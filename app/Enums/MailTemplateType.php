<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * Class MailTemplateType
 *
 * @package App\Enums
 */
final class MailTemplateType extends Enum
{
    const APPLY = 'apply';

    const CONTACT = 'contact';

    const WAITING = 'waiting';

    const APPROVED = 'approved';

    const CANCEL = 'cancel';

    const VISITED = 'visited';
}
