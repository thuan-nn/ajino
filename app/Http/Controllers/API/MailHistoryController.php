<?php

namespace App\Http\Controllers\API;

use App\Filters\MailHistoryFilter;
use App\Http\Controllers\Controller;
use App\Models\MailHistory;
use App\Sorts\MailHistorySort;
use App\Transformers\MailHistoryTransformer;
use Illuminate\Http\Request;

class MailHistoryController extends Controller
{
    /**
     * MailHistoryController constructor.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->authorizeResource(MailHistory::class);
    }

    /**
     * Get list
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Filters\MailHistoryFilter $filter
     * @param \App\Sorts\MailHistorySort $sort
     * @return \Flugg\Responder\Http\Responses\SuccessResponseBuilder|\Illuminate\Http\JsonResponse
     */
    public function index(Request $request, MailHistoryFilter $filter, MailHistorySort $sort)
    {
        $mailHistories = MailHistory::query()->filter($filter)->sortBy($sort)->paginate($this->perPage);

        return $this->httpOK($mailHistories, MailHistoryTransformer::class);
    }

    /**
     * Mail history detail
     *
     * @param \App\Models\MailHistory $mailHistory
     * @return \Flugg\Responder\Http\Responses\SuccessResponseBuilder|\Illuminate\Http\JsonResponse
     */
    public function show(MailHistory $mailHistory)
    {
        return $this->httpOK($mailHistory, MailHistoryTransformer::class);
    }
}
