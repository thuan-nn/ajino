<?php

namespace App\Actions;

use App\Models\Job;
use App\Supports\Traits\HandleTranslations;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class UpdateJobAction
{
    use HandleTranslations;

    /**
     * @param array $data
     * @param \App\Models\Job $job
     * @param string $locale
     * @throws \Throwable
     */
    public function execute(array $data, Job $job, string $locale)
    {
        $taxonomyIds = Arr::get($data, 'taxonomyIds');
        $jobData = $this->handleData($data, $locale, $job);

        DB::beginTransaction();
        try {
            $job->update($jobData);

            $job->taxonomies()->sync($taxonomyIds);

            $this->attachFiles($job, $data, $locale);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new $exception;
        }
    }
}
