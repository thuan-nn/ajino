<?php

namespace App\Http\Controllers\WEB;

use App\Actions\UploadFileAction;
use App\Enums\CaptchaKeyEnum;
use App\Enums\FileTypeEnum;
use App\Enums\MailStaffEnum;
use App\Http\Requests\ContactUsRequest;
use App\Mail\ContactUs;
use App\Models\Contact;
use App\Models\Setting;
use App\Supports\Traits\GoogleCaptchaCheker;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ContactUsController extends BaseWebController
{
    use GoogleCaptchaCheker;

    protected $files;

    /**
     * @param \App\Http\Requests\ContactUsRequest $request
     * @param \App\Actions\UploadFileAction $uploadFileAction
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \App\Exceptions\ErrorUploadException
     */
    public function execute(ContactUsRequest $request, UploadFileAction $uploadFileAction)
    {
        $this->files = $request->file('files');

        $settingCaptCha = Setting::query()
                                 ->whereIn('key', [CaptchaKeyEnum::CAPTCHA_SECRET_KEY, CaptchaKeyEnum::IS_USED_CAPTCHA])
                                 ->pluck('value', 'key')->toArray();

        if ($this->checkMatchWithCaptcha($request, $settingCaptCha) === false) {
            $url = url()->previous().($request->scroll_to ? ('#'.$request->scroll_to) : '');

            return redirect($url)->withErrors(['error_captcha' => trans('languages.RECAPTCHA_ERROR')]);
        }

        $this->saveContactUs($request, $uploadFileAction);

        $locale = request()->segment(1);

        return redirect()
            ->route('ui.posts.post.show', ['locale' => $locale, 'post' => $request->post])
            ->with('status', Response::HTTP_OK);
    }

    /**
     * @param $content
     * @param $file
     */
    public function sendMailContact($content, $file)
    {
        $mailContact = $this->getEmailContact();

        $mailable = new ContactUs($content, $file);

        Mail::to($mailContact)->queue($mailable);
    }

    /**
     * @return array|\ArrayAccess|mixed
     */
    private function getEmailContact()
    {
        $mailSetting = Setting::query()->where('key', 'email')->firstOrFail();

        $mailJson = Arr::get($mailSetting->toArray(), 'value');

        return Arr::get($mailJson, MailStaffEnum::ADMIN);
    }

    /**
     * @param $request
     * @param \App\Actions\UploadFileAction $uploadFileAction
     * @throws \App\Exceptions\ErrorUploadException
     */
    private function saveContactUs($request, UploadFileAction $uploadFileAction)
    {
        $data = $this->handleDataContact($request);

        DB::beginTransaction();
        try {
            $file = $uploadFileAction->execute($this->files, FileTypeEnum::CONTACT);
            $contact = Contact::query()->create($data);
            if ($file) {
                $contact->files()->sync($file->first()->id);
            }
            $this->sendMailContact($this->handleDataContact($request), $file);

            DB::commit();
        } catch (\HttpException $exception) {
            DB::rollBack();
            throw new $exception;
        }
    }

    /**
     * @param $request
     * @return array
     */
    private function handleDataContact($request)
    {
        $data = $request->all();

        return Arr::except($data, 'files');
    }
}
