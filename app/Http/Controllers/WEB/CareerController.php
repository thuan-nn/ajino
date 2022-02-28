<?php

namespace App\Http\Controllers\WEB;

use App\Actions\UploadFileAction;
use App\Enums\CaptchaKeyEnum;
use App\Enums\FileTypeEnum;
use App\Enums\MailStaffEnum;
use App\Http\Requests\ApplyJobRequest;
use App\Mail\ApplyJob;
use App\Models\Job;
use App\Models\PostTranslation;
use App\Models\Setting;
use App\Supports\Traits\GoogleCaptchaCheker;
use App\Supports\Traits\TransformerViewTrait;
use App\ViewModels\BaseViewModel;
use App\ViewModels\JobDetailViewModel;
use App\ViewModels\SearchCareerViewModel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class CareerController extends BaseWebController
{
    use TransformerViewTrait, GoogleCaptchaCheker;

    /**
     * @param $locale
     * @param \Illuminate\Http\Request $request
     * @return \Spatie\ViewModels\ViewModel
     */
    public function index($locale, Request $request)
    {
        $post = $this->getPostBySlug($locale, $request->post)->post;
        $allRequests = $request->all();

        return (new SearchCareerViewModel($this->globalData, $post, $allRequests))->view('web.page.search_career');
    }

    /**
     * @param $locale
     * @param \App\Models\PostTranslation $post
     * @param $jobSlug
     * @return \App\ViewModels\BaseViewModel|\App\ViewModels\JobDetailViewModel
     */
    public function show($locale, PostTranslation $post, $jobSlug)
    {
        $job = Job::query()->whereTranslation('slug', $jobSlug)->get();

        if ($job->count() === 0) {
            return (new BaseViewModel($this->globalData))->view('web.page.404_page');
        }

        return (new JobDetailViewModel($this->globalData, $post, $jobSlug))->view('web.template.job_detail');
    }

    /**
     * @param $locale
     * @param \App\Http\Requests\ApplyJobRequest $request
     * @param \App\Models\Job $job
     * @param \App\Actions\UploadFileAction $uploadFileAction
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Exceptions\ErrorUploadException
     */
    public function store(string $locale, ApplyJobRequest $request, Job $job, UploadFileAction $uploadFileAction)
    {
        $data = $request->all();
        $files = Arr::get($data, 'files');

        $translation = $job->translate($locale);

        $settingCaptCha = Setting::query()
                                 ->whereIn('key', [CaptchaKeyEnum::CAPTCHA_SECRET_KEY, CaptchaKeyEnum::IS_USED_CAPTCHA])
                                 ->pluck('value', 'key')->toArray();

        if ($this->checkMatchWithCaptcha($request, $settingCaptCha) === false) {
            return redirect(url()->previous().'#')->withErrors(['error_captcha' => trans('languages.RECAPTCHA_ERROR')]);
        }

        try {
            DB::beginTransaction();
            $candidate = $translation->candidates()->create($data);

            // upload cv
            $files = $uploadFileAction->execute($files, FileTypeEnum::CAREER);
            $fileIds = $this->getFileIds($files)->toArray();

            $candidate->files()->sync($fileIds);

            DB::commit();
        } catch (\HttpException $httpException) {
            throw new $httpException->getMessage();
        }
        // Position
        $data['position'] = $translation->title;
        $data['position_url'] = $request->url();
        $this->sendMailApply($data, $files);

        return back()->with('status', Response::HTTP_OK);
    }

    /**
     * @param $data
     * @param $files
     */
    public function sendMailApply($data, $files)
    {
        $email = $this->getMailHr();
        $data['locale'] = $this->locale;
        Mail::to($email)->queue(new ApplyJob(Arr::except($data, 'files'), $files));
    }

    /**
     * @return array|\ArrayAccess|mixed
     */
    public function getMailHr()
    {
        $mailSetting = Setting::query()->where('key', 'email')->firstOrFail();

        $mailJson = Arr::get($mailSetting->toArray(), 'value');

        return Arr::get($mailJson, MailStaffEnum::HR);
    }

    /**
     * @param $files
     * @return mixed
     */
    private function getFileIds($files)
    {
        return $files->map(function ($file) {
            return Arr::get($file->toArray(), 'id');
        });
    }
}
