<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class  VisitorStatusEnum extends Enum
{
    const REGISTERED = 'registered';

    const WAITING = 'waiting';

    const APPROVED = 'approved';

    const DENY = 'deny';

    const CANCEL = 'cancel';

    const VISITED = 'visited';

    public static function getDescription($value): string
    {
        switch ($value) {
            case self::REGISTERED:
                return 'Đăng ký mới';
            case self::WAITING:
                return 'Đang chờ';
            case self::APPROVED:
                return 'Đã duyệt';
            case self::DENY:
                return 'Từ chối';
            case self::CANCEL:
                return 'Khách huỷ';
            case self::VISITED:
                return 'Đã tham quan';
            default:
                parent::getDescription($value);
                break;
        }
    }

    /**
     * @param $value
     * @return int
     */
    public static function getCodeStatus($value): int
    {
        switch ($value) {
            case self::REGISTERED:
                return 0;
            case self::WAITING:
                return 1;
            case self::APPROVED:
                return 2;
            case self::DENY:
                return 3;
            case self::CANCEL:
                return 4;
            case self::VISITED:
                return 5;
            default:
                parent::getCodeStatus($value);
                break;
        }
    }
}
