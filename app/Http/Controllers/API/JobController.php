<?php

namespace App\Http\Controllers\API;

use App\Actions\CreateJobAction;
use App\Actions\UpdateJobAction;
use App\Filters\JobFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateJobRequest;
use App\Http\Requests\UpdateJobRequest;
use App\Models\Job;
use App\Sorts\JobSort;
use App\Transformers\JobTransformer;
use Illuminate\Http\Request;

class JobController extends Controller
{
    /**
     * JobController constructor.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function __construct(Request $request)
    {
        $this->authorizeResource(Job::class);
        $this->middleware('localeCMS');
        parent::__construct($request);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Filters\JobFilter $filter
     * @param \App\Sorts\JobSort $sort
     * @return \App\Supports\Traits\SuccessResponseBuilder|\Illuminate\Http\JsonResponse
     */
    public function index(Request $request, JobFilter $filter, JobSort $sort)
    {
        $jobs = Job::query()->filter($filter)->sortBy($sort)->paginate($this->perPage);

        return $this->httpOK($jobs, JobTransformer::class);
    }

    /**
     * @param \App\Http\Requests\CreateJobRequest $request
     * @param \App\Actions\CreateJobAction $createJobAction
     * @return \App\Supports\Traits\SuccessResponseBuilder|\Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function store(CreateJobRequest $request, CreateJobAction $createJobAction)
    {
        $data = $request->validated();

        $job = $createJobAction->execute($data, $this->locale);

        return $this->httpCreated($job, JobTransformer::class);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Job $job
     * @return \App\Supports\Traits\SuccessResponseBuilder|\Illuminate\Http\JsonResponse
     */
    public function show(Job $job)
    {
        return $this->httpOK($job, JobTransformer::class);
    }

    /**
     * @param \App\Http\Requests\UpdateJobRequest $request
     * @param \App\Models\Job $job
     * @param \App\Actions\UpdateJobAction $updateJobAction
     * @return \App\Supports\Traits\SuccessResponseBuilder|\Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function update(UpdateJobRequest $request, Job $job, UpdateJobAction $updateJobAction)
    {
        $data = $request->validated();
        $updateJobAction->execute($data, $job, $this->locale);

        return $this->httpNoContent();
    }

    /**
     * @param \App\Models\Job $job
     * @return \App\Supports\Traits\SuccessResponseBuilder|\Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Job $job)
    {
        $translation = $job->translate($this->locale);

        if (is_null($translation)) {
            return $this->httpNotFound();
        }

        $job->deleteTranslations($this->locale);

        if ($job->translations->count() == 0) {
            $job->delete();
        }

        return $this->httpNoContent();
    }
}
