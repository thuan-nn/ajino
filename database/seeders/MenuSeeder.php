<?php

namespace Database\Seeders;

use App\Enums\MenuPageType;
use App\Enums\MenuTypeEnum;
use App\Models\Menu;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $menuTypes = MenuTypeEnum::asArray();

        foreach ($menuTypes as $type => $item) {
            $menu = Menu::factory()->make([
                'name' => Str::ucfirst(str_replace('_', ' ', $item)),
                'type' => $item
            ]);
            $menu->save();
        }
        //$menuPageTypes = MenuPageType::asArray();
        //foreach ($menuPageTypes as $type => $item) {
        //    $menu = Menu::factory()->make(['name' => 'page','page'=>$item]);
        //    $menu->save();
        //}

    }
}
