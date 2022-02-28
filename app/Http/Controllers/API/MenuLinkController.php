<?php

namespace App\Http\Controllers\API;

use App\Actions\CreateMenuLinkAction;
use App\Actions\UpdateMenuLinkAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateMenuLinkRequest;
use App\Http\Requests\NestedMenuLinkRequest;
use App\Http\Requests\UpdateMenuLinkRequest;
use App\Models\MenuLink;
use App\Models\MenuLinkTranslation;
use App\Supports\Traits\HandleNestedMenuLink;
use App\Transformers\MenuLinkTransformer;
use Flugg\Responder\Exceptions\Http\HttpException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MenuLinkController extends Controller
{
    use HandleNestedMenuLink;

    /**
     * MenuLinkController constructor.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->middleware(['localeCMS']);
        $this->authorizeResource(Menulink::class);
    }

    /**
     * @return \App\Supports\Traits\SuccessResponseBuilder|\Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $menuLinks = MenuLink::query()->get()->toTree();

        return $this->httpOK($menuLinks, MenuLinkTransformer::class);
    }

    /**
     * @param \App\Http\Requests\CreateMenuLinkRequest $createMenuLinkRequest
     * @param \App\Actions\CreateMenuLinkAction $createMenuLinkAction
     * @return \App\Supports\Traits\SuccessResponseBuilder|\Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function store(CreateMenuLinkRequest $createMenuLinkRequest, CreateMenuLinkAction $createMenuLinkAction)
    {
        $data = $createMenuLinkRequest->validated();

        $menuLinks = $createMenuLinkAction->execute($data, $this->locale);

        return $this->httpCreated($menuLinks, MenuLinkTransformer::class);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\MenuLink $menu_link
     * @return \App\Supports\Traits\SuccessResponseBuilder|\Illuminate\Http\JsonResponse
     */
    public function show(MenuLink $menu_link)
    {
        return $this->httpOK($menu_link, MenuLinkTransformer::class);
    }

    /**
     * @param \App\Http\Requests\UpdateMenuLinkRequest $updateMenuLinkRequest
     * @param \App\Models\MenuLink $menu_link
     * @param \App\Actions\UpdateMenuLinkAction $updateMenuLinkAction
     * @return \App\Supports\Traits\SuccessResponseBuilder|\Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function update(
        UpdateMenuLinkRequest $updateMenuLinkRequest,
        MenuLink $menu_link,
        UpdateMenuLinkAction $updateMenuLinkAction
    ) {
        $data = $updateMenuLinkRequest->validated();
        $updateMenuLinkAction->execute($data, $menu_link, $this->locale);

        return $this->httpNoContent();
    }

    /**
     * @param \App\Models\MenuLink $menu_link
     * @return \App\Supports\Traits\SuccessResponseBuilder|\Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(MenuLink $menu_link)
    {
        $translation = $menu_link->translate($this->locale);

        if (is_null($translation)) {
            return $this->httpNotFound();
        }

        DB::beginTransaction();
        try {
            $menu_link->deleteTranslations($this->locale);

            if ($menu_link->translations->count() == 0) {
                $menu_link->update(['deleted_at' => now()]);
            }

            MenuLink::fixTree();
            DB::commit();
        } catch (HttpException $exception) {
            DB::rollBack();
            throw new $exception;
        }

        return $this->httpNoContent();
    }

    /**
     * @param \App\Http\Requests\NestedMenuLinkRequest $nestedMenuLinkRequest
     * @return \App\Supports\Traits\SuccessResponseBuilder|\Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function nestedMenuLink(NestedMenuLinkRequest $nestedMenuLinkRequest)
    {
        $data = $nestedMenuLinkRequest->validated();

        $menulinkData = $this->getMenuLinkData($data, $this->locale);

        $menulinkTranslationData = $this->getTranslationData($data, $this->locale);

        try {
            DB::beginTransaction();

            foreach ($menulinkData as $key => $menuLink) {
                $menuLink['order'] = $key;
                MenuLink::query()->find($menuLink['id'])->update($menuLink);
            }

            foreach ($menulinkTranslationData as $translation) {
                MenuLinkTranslation::query()->where('menu_link_id', $translation['menu_link_id'])
                                   ->where('locale', $translation['locale'])
                                   ->update($translation);
            }

            MenuLink::fixTree();

            DB::commit();
        } catch (HttpException $httpException) {
            DB::rollBack();

            throw new $httpException->getMessage();
        }

        return $this->httpNoContent();
    }
}
