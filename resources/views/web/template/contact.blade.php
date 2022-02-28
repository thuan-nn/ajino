@extends('index')
@section('title',$post->{'title:'.$locale}.' |')
<style>
    .noty-errors {
        color: red;
    }
</style>
@section('main')
    @include('web.component.breadcrumb',['breadcrumbs' => $breadcrumbs])

    @if($isMultipleTypeSlide)
        @include('web.component.banner_multiple',['banners' => $banners['items']])
    @elseif($isSingleTypeSlide)
        @include('web.component.banner_single',['banners' => $banners['items']])
    @else
        @include('web.component.image_cover',[
            'image' => getImageUrl($post,getFileTypeCover()),
            'title' => $post->{'title:'.$locale},
            'description' => $post->{'description:'.$locale},
        ])
    @endif

    <div class="contact container">
        <h2 class="title">{{$post->{'title:'.$locale} }}</h2>

        <div class="contact__content">
            {!! renderHtmlPreTag($post->{'content:'.$locale}) !!}

            <div class="contact__content-form">
                <h3>{{trans('languages.SEND_US')}}</h3>
                @if ($errors->has('error_captcha'))
                    <div class="error__msg">
                        <img class="error__msg-icon" src="{{asset('/assets/img/icon-error.svg')}}" alt="icon error">
                        <span>{{$errors->first('error_captcha')}}</span>
                    </div>
                @endif
                <form id="form-contact" action="{{route_ui('send_mail.contact', ['locale' => $locale])}}"
                      method="POST" class="common-form" enctype="multipart/form-data">
                    @csrf
                    <input name="post" hidden value="{{$post->{'slug:'.$locale} }}">

                    @if((boolean) $captchaKey['is_used_captcha'] && $captchaKey['captcha_site_key'])
                        <input name="captcha_site_key" hidden value="{{$captchaKey['captcha_site_key']}}">
                    @endif

                    <div class="form-wrap">
                        <div class="form-group">
                            <label for="name">{{trans('languages.FULL_NAME')}}<span>*</span></label>
                            <input type="text" class="form-control" id="name" autocomplete="off" name="name" required>
                            <span class="noty-errors">{{$errors->first('name')}}</span>
                        </div>
                        <div class="form-group">
                            <label for="phone">{{trans('languages.PHONE_NUMBER')}}<span>*</span></label>
                            <input type="text" class="form-control" id="phone" autocomplete="off" maxlength="20"
                                   name="phone_number" required>
                            <span class="noty-errors">{{$errors->first('phone_number')}}</span>
                        </div>
                    </div>
                    <div class="form-wrap">
                        <div class="form-group">
                            <label for="email">Email<span>*</span></label>
                            <input type="email" class="form-control" autocomplete="off" id="email" name="email"
                                   required>
                            <span class="noty-errors">{{$errors->first('email')}}</span>
                        </div>
                        <div class="form-group">
                            <label for="address">{{trans('languages.ADDRESS')}}</label>
                            <input type="text" class="form-control" autocomplete="off" id="address" name="address">
                            <span class="noty-errors">{{$errors->first('address')}}</span>
                        </div>
                    </div>

                    <div class="form-wrap">
                        <div class="form-group form-select-wrap">
                            <label>{{trans('languages.REASON_CONTACT')}}<span>*</span></label>
                            <select id="selectReason" class="form-control" name="reason" autocomplete="off" required>
                                <option value="" class="first" selected disabled hidden></option>

                                @if ($reasons = \App\Enums\ReasonContactEnum::asArray())
                                    @foreach($reasons as $reason)
                                        <option value="{{$reason}}">
                                            {{trans('languages.'.strtoupper($reason))}}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                            <span class="noty-errors">{{$errors->first('reason')}}</span>
                        </div>
                        <div class="form-file-upload form-group">
                            <span class="file-name"></span>
                            <label for="file-upload">{{trans('languages.MAX_SIZE_FILE')}}</label>
                            <input type="file" class="form-control" id="file-upload" autocomplete="off" name="files[]">
                            <span class="noty-errors">{{$errors->first('files')}}</span>
                        </div>
                    </div>
                    <div class="form-wrap">
                        <div class="form-group form-content">
                            <label for="content">{{trans('languages.CONTACT_CONTENT')}}<span>*</span></label>
                            <textarea class="form-control" autocomplete="off" id="content" name="content"></textarea>
                            <span class="noty-errors">{{$errors->first('content')}}</span>
                        </div>
                    </div>
                    <div class="form-wrap">
                        <div class="form-terms-use form-group">
                            <input type="checkbox" class="" id="terms-use" autocomplete="off" required>
                            <label for="terms-use">{{trans('languages.COMMITMENT')}}(<a
                                    href="#">{{trans('languages.TERMS_OF_USE')}}</a>)</label>
                        </div>
                    </div>
                    <div class="form-wrap">
                        <div class="form-group">
                            <input type="submit" class="common-btn" value="{{trans('languages.SEND')}}"
                                   data-action='submit'>
                            <input type="reset" class="common-btn" value="{{trans('languages.RELOAD')}}">
                        </div>
                    </div>
                </form>
            </div>

            <section class="common-block-product">
                <div class="block-product-wrap block-2-col">
                    @if($locationCompanies)
                        @foreach($locationCompanies as $locationCompany)
                            <div class="item">
                                <div class="item__thumb" style="background-image: url('{{getImageSetting($locationCompany->additional)}}')"></div>
                                <div class="item__content">
                                    <h3>{{$locationCompany->display_name}}</h3>
                                    <p>
                                        <span>{{$locationCompany->display_address}}</span>
                                        <span>{{$locationCompany->phone}}</span>
                                        <span>{{$locationCompany->email}}</span>
                                    </p>
                                    <p hidden class="location-company-id">{{$locationCompany->id}}</p>
                                    <a href="javascript:void(0)"
                                       class="show-map-company">{{trans('languages.SEE_MAP')}}</a>
                                </div>
                            </div>
                            <div class="popup__map common__popup">
                                <div class="common__popup-wrap">
                                    <div class="common__popup-header">
                                        <p>{{$locationCompany->display_name}}</p>
                                        <a href="javascript:void(0)" class="common__popup-close"></a>
                                    </div>
                                    <div class="common__popup-body">
                                        <iframe width="100%"
                                                height="600"
                                                frameborder="0"
                                                scrolling="no"
                                                marginheight="0"
                                                marginwidth="0"
                                                src="https://maps.google.com/maps?width=100%25&amp;height=600&amp;hl=en&amp;q={{$locationCompany->address}}+()&amp;t=&amp;z=14&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"></iframe>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </section>
        </div>
    </div>
    @include('web.component.popup_mail',['type'=>'contact'])
@endsection


@if((boolean) $captchaKey['is_used_captcha'] && $captchaKey['captcha_site_key'])
@section('script')
    <script src="https://www.google.com/recaptcha/api.js?render={{$captchaKey['captcha_site_key']}}"></script>
    <script>
        /* Set Token for Captcha */
        grecaptcha.ready(function () {
            grecaptcha.execute("{{$captchaKey['captcha_site_key']}}", {action: 'submit'}
            ).then(function (token) {
                $('#form-contact').prepend('<input type="hidden" name="token_captcha" value="' + token + '">')
            })
        })
    </script>
@endsection
@endif
