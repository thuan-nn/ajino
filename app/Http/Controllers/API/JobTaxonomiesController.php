<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\AttachTaxonomiesJobRequest;
use App\Models\Job;
use App\Models\Taxonomy;

class JobTaxonomiesController extends Controller
{
    public function store(AttachTaxonomiesJobRequest $request, Job $job)
    {
        $data = $request->validated();
        $taxonomyIds = Arr::get($data, 'taxonomyIds');

        $job->taxonomies()->sync($taxonomyIds);

        return $this->httpCreated();
    }
}
