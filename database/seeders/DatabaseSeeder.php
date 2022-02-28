<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            AdminSeeder::class,
            RoleAndPermissionSeeder::class,
            //MenuSeeder::class,
            //TaxonomySeeder::class,
            //PostSeeder::class,
            LocationSeeder::class,
            //JobSeeder::class,
            //CandidateSeeder::class,
            //CompanyTourSeeder::class,
            //VisitorSeeder::class,
            //BannerSeeder::class,
            SettingSeeder::class,
        ]);
    }
}
