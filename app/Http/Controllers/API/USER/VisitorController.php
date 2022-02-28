<?php

namespace App\Http\Controllers\API\USER;

use App\Actions\CreateVisitorAction;
use App\Enums\CaptchaKeyEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\CreateVisitorRequest;
use App\Models\Setting;
use App\Supports\Traits\GoogleCaptchaCheker;
use App\Transformers\VisitorTransformer;

class VisitorController extends Controller
{
    use GoogleCaptchaCheker;

    /**
     * @param \App\Http\Requests\User\CreateVisitorRequest $request
     * @param \App\Actions\CreateVisitorAction $action
     * @return \Flugg\Responder\Http\Responses\SuccessResponseBuilder|\Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function store(CreateVisitorRequest $request, CreateVisitorAction $action)
    {
        $locale = $request->get('locale');
        $settingCaptCha = Setting::query()
                                 ->whereIn('key', [
                                     CaptchaKeyEnum::CAPTCHA_SECRET_KEY,
                                     CaptchaKeyEnum::IS_USED_CAPTCHA,
                                 ])
                                 ->pluck('value', 'key')
                                 ->toArray();

        if ($this->checkMatchWithCaptcha($request, $settingCaptCha) === false) {
            $errors = [
                [
                    'field'   => 'error_captcha',
                    'message' => [
                        trans('languages.RECAPTCHA_ERROR', [], $locale),
                    ],
                ],
            ];

            return response()->json(['errors' => $errors], 400);
        }

        $data = $request->validated();
        $visitor = $action->execute($data);

        return $this->httpCreated($visitor, VisitorTransformer::class);
    }
}
