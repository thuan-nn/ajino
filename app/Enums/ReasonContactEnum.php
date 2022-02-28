<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class ReasonContactEnum extends Enum
{
    const ORDER = 'order';

    const QUESTION = 'question';

    const COMPLAIN = 'complain';

    const OTHER = 'other';

    public static function getDescription($value): string
    {
        switch ($value) {
            case self::ORDER:
                return 'Đặt hàng';
            case self::QUESTION:
                return 'Câu hỏi';
            case self::COMPLAIN:
                return 'Góp ý';
            case self::OTHER:
                return 'Khác';
            default:
                return parent::getDescription($value);
        }
    }
}
