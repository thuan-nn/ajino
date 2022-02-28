<?php

namespace Database\Seeders;

use App\Models\MailHistory;
use Illuminate\Database\Seeder;

class MailHistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MailHistory::factory()->count(10)->create();
    }
}
