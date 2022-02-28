<?php

namespace App\Models;

use App\Builders\SettingBuilder;
use App\Supports\Traits\OverridesBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class Setting extends Model
{
    use OverridesBuilder;

    protected $table = 'setting';

    protected $fillable = [
        'key',
        'value',
    ];

    protected $casts = [
        'value' => 'json',
    ];

    public function provideCustomBuilder()
    {
        return SettingBuilder::class;
    }

    public function getValueAttribute($value) {
        $settingValue = json_decode($value, true);
        if (is_array($settingValue)) {
            $settingValue = array_map(function ($item) {
                if (!empty($item['image']) && is_array($item['image'])) {
                    $item['image'] = array_map(function ($item) {
                        $item['url'] = config('app.url').parse_url($item['url'], PHP_URL_PATH);
                        return $item;
                    }, $item['image']);
                }
                return $item;
            }, $settingValue);
            return $settingValue;
        }
        return $settingValue;
    }
}
