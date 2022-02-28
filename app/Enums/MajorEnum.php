<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * Class MajorEnum
 *
 * @package App\Enums
 */
final class MajorEnum extends Enum
{
    const PUPIL = 'pupil';

    const STUDENT = 'student';

    const TEACHER = 'teacher';

    const OFFICE_WORKER = 'office_worker';

    const HOUSEWIFE = 'HOUSEWIFE';

    const OTHERS = 'other';

    public static function getDescription($value): string
    {
        switch ($value) {
            case self::PUPIL:
                return trans('languages'.'.'.strtoupper(self::PUPIL));
            case self::STUDENT:
                return trans('languages'.'.'.strtoupper(self::STUDENT));
            case self::TEACHER:
                return trans('languages'.'.'.strtoupper(self::TEACHER));
            case self::OFFICE_WORKER:
                return trans('languages'.'.'.strtoupper(self::OFFICE_WORKER));
            case self::HOUSEWIFE:
                return trans('languages'.'.'.strtoupper(self::HOUSEWIFE));
            case self::OTHERS:
                return trans('languages'.'.'.strtoupper(self::OTHERS).'S');
            default:
                return parent::getDescription($value);
        }
    }
}
