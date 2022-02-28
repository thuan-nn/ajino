<?php

namespace App\Actions;

use App\Models\Job;
use App\Supports\Traits\HandleTranslations;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class CreateJobAction
{
    use HandleTranslations;

    /**
     * @param $data
     *
     * @param string $locale
     * @return mixed
     * @throws \Throwable
     */
    public function execute($data, string $locale)
    {
        $job = new Job();
        $taxonomyIds = Arr::get($data, 'taxonomyIds');
        $jobData = $this->handleData($data, $locale, $job);

        DB::beginTransaction();
        try {
            $job = $job->create($jobData);

            $job->taxonomies()->sync($taxonomyIds);

            $this->attachFiles($job, $data, $locale);
            DB::commit();
        } catch (\HttpException $httpException) {
            DB::rollBack();
            throw new $httpException->getMessage();
        }

        return $job;
    }
}
