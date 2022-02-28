@extends('index')
@section('title',$page->{'title:'.$locale}.' | ')
@section('main')
    @if($isMultipleTypeSlide)
        @include('web.component.banner_multiple',['banners' => $banners['items']])
    @elseif($isSingleTypeSlide)
        @include('web.component.banner_single',['banners' => $banners['items']])
    @else
        @include('web.component.image_cover',[
            'image' => getImageUrl($page, getFileTypeCover()),
            'title' => $page->{'title:'.$locale},
            'description' => $page->{'description:'.$locale},
        ])
    @endif

    <div class="company company-register container">
        <h2 class="title">{{$page->{'title:'.$locale} }}</h2>

        <div class="company__content">
            <p>{{trans('languages.SELECT_COMPANY_TITLE')}}</p>

            @if($locations)
                <div class="company-register__select">
                    <select>
                        @foreach($locations as $key => $location)
                            <option
                                    value="{{$location->id}}" {{($key === 0) ? "selected" : ""}} >{{$location->display_name}}</option>
                        @endforeach
                    </select>
                </div>
            @endif
            <h3>{{trans('languages.CHOOSE_DATE_TITLE')}}</h3>
            <div class="company-register__time">
                <div class="company-register__time-wrap">
                    <span class="morning">{{trans('languages.STATUS_CALENDAR_MORNING')}}</span>
                    <span class="morning morning--bg">{{trans('languages.STATUS_CALENDAR_SPECIAL_MORNING')}}</span>

                </div>
                <div class="company-register__time-wrap">
                    <span class="afternoon">{{trans('languages.STATUS_CALENDAR_AFTERNOON')}}</span>
                    <span
                            class="afternoon afternoon--bg">{{trans('languages.STATUS_CALENDAR_SPECIAL_AFTERNOON')}}</span>

                </div>
                <div class="company-register__time-wrap">
                    <span class="block">{{trans('languages.STATUS_CALENDAR_LOCKED')}}</span>
                </div>
            </div>

            <div class="company-register__calendar">
                <div id='calendar'></div>
            </div>

            <div class="company-register__content">

            </div>

            <div class="company__content-map">
                <h3 class="company__content-name"></h3>

                <a class="company__content-facebook" href="" target="_blank">
                    <img src="{{asset('assets/img/icon-facebook.png')}}" alt="icon facebook">
                </a>
            </div>

            <div class="company-register__map"></div>
        </div>
    </div>

    @include('web.component.popup_register_company')

    @include('web.component.popup_mail',['type'=>'company'])
@endsection
<!-- Load Facebook SDK for JavaScript -->
<div id="fb-root"></div>
<script>
  window.fbAsyncInit = function () {
    FB.init({
      xfbml: true,
      version: 'v9.0'
    })
  };

  (function (d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0]
    if (d.getElementById(id)) return
    js = d.createElement(s)
    js.id = id
    js.src = 'https://connect.facebook.net/vi_VN/sdk/xfbml.customerchat.js'
    fjs.parentNode.insertBefore(js, fjs)
  }(document, 'script', 'facebook-jssdk'))</script>

<!-- Your Chat Plugin code -->
<div class="fb-customerchat"
     attribution="setup_tool"
     page_id="1269339429899270"
     theme_color="#fa3c4c"
     logged_in_greeting="Xin chào! Bạn cần thông tin gì từ Ajinomoto?"
     logged_out_greeting="Xin chào! Bạn cần thông tin gì từ Ajinomoto?">
</div>
@section('script')
    <script>
        document.getElementsByTagName('head')[0].appendChild(document.querySelector("link[rel*='icon']"))
    </script>
    <script src="{{asset('/js/vendor/fullcalendar.min.js')}}"></script>

    @if((boolean) $captchaKey['is_used_captcha'] && $captchaKey['captcha_site_key'])
        <script src="https://www.google.com/recaptcha/api.js?render={{$captchaKey['captcha_site_key']}}"></script>
        <script>
            /* Set Token for Captcha */
            grecaptcha.ready(function () {
                grecaptcha.execute("{{$captchaKey['captcha_site_key']}}", { action: 'submit' }
                ).then(function (token) {
                    $('#register-company-tour').prepend('<input id="token_captcha" type="hidden" name="token_captcha" value="' + token + '">')
                })
            })

            const timeInterval = setInterval(function () {
                grecaptcha.ready(function () {
                    grecaptcha.execute("{{$captchaKey['captcha_site_key']}}", {action: "submit"}).then(function (token) {
                        if ($('#token_captcha').length) {
                            $('#token_captcha').val(token)
                        }
                    })
                })
            }, 90 * 1000)

            clearInterval(timeInterval)
        </script>
    @endif
@endsection