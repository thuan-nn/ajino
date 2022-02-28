<?php

namespace App\Models;

use App\Supports\Traits\HasUuid;
use App\Supports\Traits\ModelTranslationTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MenuLinkTranslation extends Model
{
    use HasFactory, HasUuid, ModelTranslationTrait, SoftDeletes;

    protected $table = 'menulink_translations';

    protected $fillable = [
        'menu_link_id',
        'title',
        'locale',
        'url',
        'additional',
    ];

    protected $casts = [
        'additional' => 'json',
    ];

    public function menulink()
    {
        return $this->belongsTo(MenuLink::class, 'menu_link_id');
    }
}
