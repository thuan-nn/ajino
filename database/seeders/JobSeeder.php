<?php

namespace Database\Seeders;

use App\Enums\LanguageEnum;
use App\Models\Job;
use App\Models\JobTranslation;
use Illuminate\Database\Seeder;

class JobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Job::factory()->count('50')->create();
        $jobs = Job::query();

        $jobs->eachById(function ($job) {
            foreach (LanguageEnum::asArray() as $lang) {
                $translation = Jobtranslation::factory()->make(['job_id' => $job->id]);
                $translation->locale = strtolower($lang);
                $translation->save();
            }
        });
    }
}
