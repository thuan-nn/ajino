<?php

namespace Database\Seeders;

use App\Models\CompanyTour;
use Illuminate\Database\Seeder;

class CompanyTourSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CompanyTour::factory()->count(50)->create();
    }
}
