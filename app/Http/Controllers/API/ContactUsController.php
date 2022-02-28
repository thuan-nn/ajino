<?php

namespace App\Http\Controllers\API;

use App\Actions\CreateContactUsAction;
use App\Actions\UpdateContactUsAction;
use App\Filters\ContactUsFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateContactUsRequest;
use App\Http\Requests\UpdateContactUsRequest;
use App\Models\Contact;
use App\Sorts\ContactUsSort;
use App\Transformers\ContactUsTransformer;
use Illuminate\Http\Request;

class ContactUsController extends Controller
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->authorizeResource(Contact::class);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Filters\ContactUsFilter $filter
     * @param \App\Sorts\ContactUsSort $sort
     * @return \Flugg\Responder\Http\Responses\SuccessResponseBuilder|\Illuminate\Http\JsonResponse
     */
    public function index(Request $request, ContactUsFilter $filter, ContactUsSort $sort)
    {
        $contact = Contact::query()->filter($filter)->sortBy($sort)->paginate($this->perPage);

        return $this->httpOK($contact, ContactUsTransformer::class);
    }

    /**
     * @param \App\Http\Requests\CreateContactUsRequest $request
     * @param \App\Actions\CreateContactUsAction $action
     * @return \Flugg\Responder\Http\Responses\SuccessResponseBuilder|\Illuminate\Http\JsonResponse
     */
    public function store(CreateContactUsRequest $request, CreateContactUsAction $action)
    {
        $data = $request->validated();
        $contact = $action->execute($data);

        return $this->httpCreated($contact, ContactUsTransformer::class);
    }

    /**
     * @param \App\Models\Contact $contact
     * @return \Flugg\Responder\Http\Responses\SuccessResponseBuilder|\Illuminate\Http\JsonResponse
     */
    public function show(Contact $contact)
    {
        $contact->update(['is_open' => true]);
        
        return $this->httpOK($contact, ContactUsTransformer::class);
    }

    /**
     * @param \App\Http\Requests\UpdateContactUsRequest $request
     * @param \App\Models\Contact $contact
     * @param \App\Actions\UpdateContactUsAction $action
     * @return \Flugg\Responder\Http\Responses\SuccessResponseBuilder|\Illuminate\Http\JsonResponse
     */
    public function update(UpdateContactUsRequest $request, Contact $contact, UpdateContactUsAction $action)
    {
        $data = $request->validated();

        $action->execute($data, $contact);

        return $this->httpNoContent();
    }

    /**
     * @param \App\Models\Contact $contact
     * @return \Flugg\Responder\Http\Responses\SuccessResponseBuilder|\Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Contact $contact)
    {
        $contact->delete();

        return $this->httpNoContent();
    }
}
