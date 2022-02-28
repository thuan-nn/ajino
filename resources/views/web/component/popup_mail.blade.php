@php
    switch($type):
        case('contact'):
            $title = trans('popup.EMAIL_CONTACT_TITLE');
            $content = trans('popup.EMAIL_CONTACT_CONTENT');
            break;
        case('job'):
            $title = trans('popup.EMAIL_JOB_TITLE');
            $content = trans('popup.EMAIL_JOB_CONTENT');
            break;
        case('company'):
            $title = trans('popup.EMAIL_COMPANY_VISIT_TITLE');
            $content = trans('popup.EMAIL_COMPANY_VISIT_CONTENT');
            break;
        default:
        $title = '';
        $content = '';
    endswitch
@endphp
<div class="popup__success common__popup {{ Session::get('status') ? 'show':''}}">
    <div class="common__popup-wrap">
        <div class="common__popup-header">
            <a href="javascript:void(0)" class="common__popup-close"></a>
        </div>
        <div class="common__popup-body">
            <img src="{{asset('/assets/img/contact-form-01.svg')}}" alt="image success">
            <h3>{{$title}}</h3>
            <p>{{$content}}</p>
            <a href="javascript:void(0)" class="common-btn">{{trans('languages.BACK')}}</a>
        </div>
    </div>
</div>