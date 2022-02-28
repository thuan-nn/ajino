@extends('index')
@section('title', $job->{'title:'. $locale}.' | ')
<style>
    .noty-errors {
        color: red;
    }
</style>
@section('main')
    @include('web.component.breadcrumb', ['breadcrumbs' => $breadcrumbs])

    <div class="career career-detail container">
        <h2 class="title">{{$job->{'title:'. $locale} }}</h2>

        <div class="common__follows">
            <a href="https://www.facebook.com/sharer/sharer.php?u={{request()->url()}}">
                <img src="{{asset('assets/img/icon-facebook-blue.svg')}}" alt="icon facebook">
            </a>
            <a class="zalo-share-button" data-href="{{request()->url()}}" data-oaid="1331366046186962384"
               data-layout="2" data-color="blue" data-customize=true>
                <img class="img-mxh"
                     src="{{asset('assets/img/icon-zalo.svg')}}"
                     width="32" height="32">
            </a>
        </div>

        <div class="career__content post-container">
            <div class="mb-5">{!! renderHtmlPreTag($job->{'description:'. $locale}) !!}</div>

            <div class="career__content-block">
                <div class="career__content-inner">
                    <p>{{trans('languages.WORKPLACE')}}</p>

                    <p style="width: auto">{{$job->location->display_name}}</p>
                </div>

                <div class="career__content-inner">
                    <p>{{trans('languages.JOB_TYPE')}}</p>

                    <p style="width: auto">{{$job->{'job_type:'. $locale} }}</p>
                </div>
            </div>
            <div class="career-detail__form">
                <h3>{{trans('languages.RECRUITMENT')}}</h3>
                @if ($errors->has('error_captcha'))
                    <div class="error__msg">
                        <img class="error__msg-icon" src="{{asset('/assets/img/icon-error.svg')}}" alt="icon error">
                        <span>{{$errors->first('error_captcha')}}</span>
                    </div>
                @endif
                <form id="form-recruitment" action="{{route_ui('send_mail.job',['locale' => $locale, 'job' => $job])}}"
                      method="POST" class="common-form" enctype="multipart/form-data">
                    @csrf
                    @if(isset($captchaKey['is_used_captcha']) && isset($captchaKey['captcha_site_key']) )
                        @if((boolean) $captchaKey['is_used_captcha'] && $captchaKey['captcha_site_key'])
                            <input name="captcha_site_key" hidden value="{{$captchaKey['captcha_site_key']}}">
                        @endif
                    @endisset
                    <div class="form-wrap">
                        <div class="form-group">
                            <label for="name">{{trans('languages.FULL_NAME')}}<span>*</span></label>
                            <input type="text" class="form-control" id="name" name="name" autocomplete="off" required>
                            <span class="noty-errors">{{$errors->first('name')}}</span>
                        </div>
                        <div class="form-select-wrap form-group">
                            <select class="form-control" name="gender" autocomplete="off">
                                <option value="0" selected>{{trans('languages.MALE')}}</option>
                                <option value="1">{{trans('languages.FEMALE')}}</option>
                            </select>
                            <span class="noty-errors">{{$errors->first('gender')}}</span>
                        </div>
                    </div>
                    <div class="form-wrap">
                        <div class="form-group">
                            <label for="email">Email<span>*</span></label>
                            <input type="email" class="form-control" id="email" name="email" autocomplete="off" required>
                            <span class="noty-errors">{{$errors->first('email')}}</span>
                        </div>
                        <div class="form-group">
                            <label for="phone">{{trans('languages.PHONE_NUMBER')}}<span>*</span></label>
                            <input type="text" class="form-control" id="phone" autocomplete="off" maxlength="20"
                                   name="phone_number" required>
                            <span class="noty-errors">{{$errors->first('phone_number')}}</span>
                        </div>
                    </div>
                    <div class="form-wrap">
                        <div class="form-file-upload form-group">
                            <label for="file-upload">{{trans('languages.MAX_SIZE_FILE')}} <span>*</span></label>
                            <input type="file" class="form-control" id="file-upload" multiple required name="files[]" autocomplete="off">
                            <span>{{trans('languages.LIMIT_FILE')}}</span>
                            @foreach ($errors->get('files') as $key => $error)
                                <br><span class="noty-errors">{{$error}}</span>
                            @endforeach

                            <div class="file-list">

                            </div>
                        </div>
                    </div>
                    <div class="form-wrap">
                        <div class="form-group form-title">
                            <label for="title">{{trans('languages.TITLE')}}</label>
                            <input type="text" class="form-control" id="title" name="title" autocomplete="off">
                        </div>
                        <div class="form-group form-content">
                            <label for="content">{{trans('languages.CONTENT')}}</label>
                            <textarea class="form-control" id="content" name="content" autocomplete="off"></textarea>
                        </div>
                    </div>
                    <p>{{trans('languages.PROMISE')}}</p>
                    <div class="form-wrap">
                        <div class="form-group form-terms-use">
                            <input type="checkbox" class="" id="terms-use" required>
                            <label for="terms-use">
                                {{trans('languages.COMMITMENT')}}
                                (<a href="#">{{trans('languages.TERMS_OF_USE')}}</a>)
                            </label>
                        </div>
                    </div>
                    <input type="submit" class="common-btn" value="{{trans('languages.APPLY')}}" data-action='submit'>
                </form>
            </div>
        </div>

        @include('web.component.popup_mail',['type'=>'job'])
    </div>
@endsection
@if(isset($captchaKey['is_used_captcha']) &&
    isset($captchaKey['captcha_site_key']) &&
    (boolean) $captchaKey['is_used_captcha'] &&
    $captchaKey['captcha_site_key'])
@section('script')
    <script src="https://www.google.com/recaptcha/api.js?render={{$captchaKey['captcha_site_key']}}"></script>
    <script>
      /* Set Token for Captcha */
      grecaptcha.ready(function () {
        grecaptcha.execute("{{$captchaKey['captcha_site_key']}}", { action: 'submit' },
        ).then(function (token) {
          $('#form-recruitment').prepend('<input type="hidden" name="token_captcha" value="' + token + '">')
        })
      })
    </script>
@endsection
@endif
