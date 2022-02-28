<?php

namespace App\Models;

use App\Builders\MenuBuilder;

class Menu extends BaseModel
{
    /**
     * @return string
     */
    public function provideCustomBuilder()
    {
        return MenuBuilder::class;
    }

    /**
     * @var string
     */
    protected $table = 'menus';

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'class',
        'is_published',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function menulinks()
    {
        return $this->hasMany(MenuLink::class, 'menu_id', 'id');
    }
}
