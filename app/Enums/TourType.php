<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class TourType extends Enum
{
    const MORNING = 'morning';

    const AFTERNOON = 'afternoon';

    const SPECIAL_MORNING = 'special-morning';

    const SPECIAL_AFTERNOON = 'special-afternoon';

    public static function getDescription($value): string
    {
        switch ($value) {
            case self::MORNING:
                return 'Buổi sáng';
                break;
            case self::SPECIAL_MORNING:
                return 'Buổi sáng đặc biệt';
                break;
            case self::AFTERNOON:
                return 'Buổi chiều';
                break;
            case self::SPECIAL_AFTERNOON:
                return 'Buổi chiều đặc biệt';
                break;
            default:
                parent::getDescription($value);
                break;
        }
    }
}
