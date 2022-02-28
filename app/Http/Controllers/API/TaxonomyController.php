<?php

namespace App\Http\Controllers\API;

use App\Actions\CreateTaxonomyAction;
use App\Actions\DeleteTaxonomyAction;
use App\Actions\UpdateTaxonomyAction;
use App\Filters\TaxonomyFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateTaxonomyRequest;
use App\Http\Requests\UpdateTaxonomyRequest;
use App\Models\Taxonomy;
use App\Sorts\TaxonomySort;
use App\Transformers\TaxonomyTransformer;
use Illuminate\Http\Request;

class TaxonomyController extends Controller
{
    /**
     * TaxonomyController constructor.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->middleware(['localeCMS']);
        $this->authorizeResource(Taxonomy::class);
    }

    /**
     * @param Request $request
     *
     * @param TaxonomyFilter $filter
     *
     * @param TaxonomySort $sort
     *
     * @return \App\Supports\Traits\SuccessResponseBuilder|\Illuminate\Http\JsonResponse
     */
    public function index(Request $request, TaxonomyFilter $filter, TaxonomySort $sort)
    {
        $taxonomies = Taxonomy::query()->filter($filter)->sortBy($sort)->paginate($this->perPage);

        return $this->httpOK($taxonomies, TaxonomyTransformer::class);
    }

    /**
     * @param CreateTaxonomyRequest $request
     * @param CreateTaxonomyAction $createTaxonomyAction
     *
     * @return \App\Supports\Traits\SuccessResponseBuilder|\Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function store(CreateTaxonomyRequest $request, CreateTaxonomyAction $createTaxonomyAction)
    {
        $data = $request->validated();

        $taxonomy = $createTaxonomyAction->execute($data, $this->locale);

        return $this->httpCreated($taxonomy, TaxonomyTransformer::class);
    }

    /**
     * @param \App\Models\Taxonomy $taxonomy
     * @return \Flugg\Responder\Http\Responses\SuccessResponseBuilder|\Illuminate\Http\JsonResponse
     */
    public function show(Taxonomy $taxonomy)
    {
        if (request('type') !== $taxonomy->type) {
            return $this->httpNotFound();
        }

        return $this->httpOK($taxonomy, TaxonomyTransformer::class);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateTaxonomyRequest $request
     * @param Taxonomy $taxonomy
     * @param UpdateTaxonomyAction $taxonomyAction
     *
     * @return \App\Supports\Traits\SuccessResponseBuilder|\Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function update(UpdateTaxonomyRequest $request, Taxonomy $taxonomy, UpdateTaxonomyAction $taxonomyAction)
    {
        if (request('type') !== $taxonomy->type) {
            return $this->httpNotFound();
        }
        $data = $request->validated();
        $taxonomyAction->execute($data, $taxonomy, $this->locale);

        return $this->httpNoContent();
    }

    /**
     * @param \App\Models\Taxonomy $taxonomy
     * @param \App\Actions\DeleteTaxonomyAction $action
     * @return \Flugg\Responder\Http\Responses\SuccessResponseBuilder|\Illuminate\Http\JsonResponse
     * @throws \HttpException
     */
    public function destroy(Taxonomy $taxonomy, DeleteTaxonomyAction $action)
    {
        if (request('type') !== $taxonomy->type) {
            return $this->httpNotFound();
        }
        $translation = $taxonomy->translate($this->locale);

        if (is_null($translation)) {
            return $this->httpNotFound();
        }

        $action->execute($taxonomy, $this->locale);

        return $this->httpNoContent();
    }
}
