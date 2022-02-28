<?php

namespace Database\Seeders;

use App\Models\Candidate;
use App\Models\JobTranslation;
use Illuminate\Database\Seeder;

class CandidateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jobTranslations = JobTranslation::query();

        $jobTranslations->eachById(function ($jobTranslation) {
            $candidate = Candidate::factory()->make();
            $candidate->job_translation_id = $jobTranslation->id;
            $candidate->save();
        });
    }
}
