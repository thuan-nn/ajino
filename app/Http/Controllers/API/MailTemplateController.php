<?php

namespace App\Http\Controllers\API;

use App\Actions\CreateMailTemplateAction;
use App\Enums\MailParameterEnum;
use App\Filters\MailTemplateFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateMailTemplateRequest;
use App\Http\Requests\UpdateMailTemplateRequest;
use App\Models\MailTemplate;
use App\Sorts\MailTemplateSort;
use App\Transformers\MailTemplateTransformer;
use Illuminate\Http\Request;

class MailTemplateController extends Controller
{
    /**
     * MailTemplateController constructor.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->authorizeResource(MailTemplate::class);
    }

    /**
     * List mail template
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Filters\MailTemplateFilter $filter
     * @param \App\Sorts\MailTemplateSort $sort
     * @return \Flugg\Responder\Http\Responses\SuccessResponseBuilder|\Illuminate\Http\JsonResponse
     */
    public function index(Request $request, MailTemplateFilter $filter, MailTemplateSort $sort)
    {
        $mailTemplate = MailTemplate::query()->where('language',$this->locale)->filter($filter)->sortBy($sort)->paginate($this->perPage);

        return $this->httpOK($mailTemplate, MailTemplateTransformer::class);
    }

    /**
     * Mail template detail
     *
     * @param \App\Models\MailTemplate $mailTemplate
     * @return \Flugg\Responder\Http\Responses\SuccessResponseBuilder|\Illuminate\Http\JsonResponse
     */
    public function show(MailTemplate $mailTemplate)
    {
        return $this->httpOK($mailTemplate, MailTemplateTransformer::class);
    }

    /**
     * Create mail template
     *
     * @param \App\Http\Requests\CreateMailTemplateRequest $mailTemplateRequest
     * @param \App\Actions\CreateMailTemplateAction $createMailTemplateAction
     * @return \Flugg\Responder\Http\Responses\SuccessResponseBuilder|\Illuminate\Http\JsonResponse
     */
    public function store(CreateMailTemplateRequest $mailTemplateRequest, CreateMailTemplateAction $createMailTemplateAction)
    {
        $data = $mailTemplateRequest->validated();

        $mailTemplate = $createMailTemplateAction->execute($data);

        return $this->httpCreated($mailTemplate, MailTemplateTransformer::class);
    }

    /**
     * Update mail template
     *
     * @param \App\Http\Requests\UpdateMailTemplateRequest $mailTemplateRequest
     * @param \App\Models\MailTemplate $mailTemplate
     * @return \Flugg\Responder\Http\Responses\SuccessResponseBuilder|\Illuminate\Http\JsonResponse
     */
    public function update(UpdateMailTemplateRequest $mailTemplateRequest, MailTemplate $mailTemplate)
    {
        $data = $mailTemplateRequest->validated();
        $mailTemplate->update($data);

        return $this->httpNoContent();
    }

    /**
     * Delete template
     *
     * @param \App\Models\MailTemplate $mailTemplate
     * @return \Flugg\Responder\Http\Responses\SuccessResponseBuilder|\Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(MailTemplate $mailTemplate)
    {
        $mailTemplate->delete();

        return $this->httpNoContent();
    }

    /**
     * Get mails parameters
     *
     * @return \Flugg\Responder\Http\Responses\SuccessResponseBuilder|\Illuminate\Http\JsonResponse
     */
    public function getParameters()
    {
        return $this->httpOK(MailParameterEnum::getAll($this->locale));
    }
}
