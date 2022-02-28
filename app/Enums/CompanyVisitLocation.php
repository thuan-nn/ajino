<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class CompanyVisitLocation extends Enum
{
    const LONGTHANH = 'longthanh';

    const BIENHOA = 'bienhoa';

    const HANOI = 'hanoi';

    public static function getDescription($value): string
    {
        switch ($value) {
            case self::LONGTHANH:
                return 'Nhà máy Ajinomoto Long Thành';
            case self::BIENHOA:
                return 'Nhà máy Ajinomoto Biên Hòa';
            case self::HANOI:
                return 'Văn phòng Ajinomoto tại Hà Nội';
            default:
                return parent::getDescription($value);
        }
    }
}
