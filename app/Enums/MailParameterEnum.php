<?php

namespace App\Enums;

use BenSampo\Enum\Enum;
use Illuminate\Support\Str;

final class MailParameterEnum extends Enum
{
    const APPLY = [
        'name',
        'gender',
        'email',
        'phone_number',
        'position',
        'position_url',
    ];

    const CONTACT = [
        'reason',
        'content',
        'name',
        'phone_number',
        'address',
        'email',
    ];

    const WAITING = [
        'name',
        'email',
        'phone_number',
        'address',
        'date',
        'type',
        'amount_visitor',
    ];

    const APPROVED = [
        'name',
        'email',
        'phone_number',
        'address',
        'date',
        'type',
        'amount_visitor',
    ];

    const CANCEL = [
        'name',
        'email',
        'phone_number',
        'address',
        'date',
        'type',
        'amount_visitor',
    ];

    const VISITED = [
        'name',
        'email',
        'phone_number',
        'address',
        'date',
        'type',
        'amount_visitor',
    ];

    public static function getAll($local)
    {
        $params = self::asArray();
        $data = [];

        collect($params)->each(function ($para, $key) use ($local, &$data) {
            $fields = collect($para)->map(function ($item) use ($local) {
                return [
                    'key'  => $item,
                    'name' => trans('parameters.'.$item, [], $local),
                ];
            })->toArray();
            $data[Str::lower($key)] = $fields;
        });
        return $data;
    }
}
