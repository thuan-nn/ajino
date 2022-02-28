<style>
    .notify-errors {
        color: #D8000C;
    }
</style>
<div class="popup__register common__popup " role="alert">
    <div class="common__popup-wrap">
        <div class="common__popup-header">
            <h3>{{trans('languages.REGISTER_COMPANY_VISIT')}}</h3>
            <a href="javascript:void(0)" class="common__popup-close"></a>
        </div>
        <div class="common__popup-body">
            <div class="company-register__form">
                <div class="company-register__form-header">
                    <div>
                        <h4 class="time-events"></h4>
                        <h4 class="location"></h4>
                    </div>
                    <p class="register-amount">{{trans('languages.REGISTERED')}}</p>
                </div>

                <div class="error__msg">
                    <img class="error__msg-icon" src="{{asset('/assets/img/icon-error.svg')}}" alt="icon error">

                </div>
                <form id="register-company-tour" class="common-form">
                    @if((boolean) $captchaKey['is_used_captcha'] && $captchaKey['captcha_site_key'])
                        <input name="captcha_site_key" hidden value="{{$captchaKey['captcha_site_key']}}">
                    @endif
                    <div class="form-wrap">
                        <div class="form-group">
                            <label for="name">{{trans('languages.FULL_NAME')}}<span>*</span></label>
                            <input type="text" class="form-control" id="name" name="name" autocomplete="off" required>
                        </div>

                        <div class="form-group form-select-wrap">
                            <label>{{trans('languages.OBJECTS_TO_VISIT')}}<span>*</span></label>
                            @if ($majors)
                                <select id="selectMajors" class="form-control" name="majors" autocomplete="off"
                                        required>
                                    <option value="" class="first" selected hidden disabled></option>
                                    @foreach($majors as $key => $major)
                                        <option value="{{$key}}">{{$major}}</option>
                                    @endforeach
                                </select>
                            @endif

                        </div>
                    </div>
                    <div class="form-wrap">
                        <div class="form-group">
                            <label for="workplace">{{trans('languages.ORGANIZATION')}}<span>*</span></label>
                            <input type="text" class="form-control" id="workplace" autocomplete="off"
                                   name="job_location" required>
                            <small class="text">{{trans('languages.FACULTY_DEPARTMENT')}}</small>
                        </div>

                        <div class="form-group">
                            <label for="address">{{trans('languages.ADDRESS')}}<span>*</span></label>
                            <input type="text" class="form-control" id="address" autocomplete="off" name="address"
                                   required>
                        </div>
                    </div>

                    <div class="form-wrap">
                        <div class="form-group form-select-wrap">
                            <label>{{trans('languages.SELECT_PROVINCE')}}<span>*</span></label>

                            @if ($locationVisitors)
                                <select id="selectLocationVisitors" class="form-control" name="city"
                                        autocomplete="off" required>
                                    <option value="" class="first" selected hidden disabled></option>
                                    @foreach($locationVisitors as $locationVisitor)
                                        <option value="{{$locationVisitor->id}}">{{$locationVisitor->display_name}}</option>
                                    @endforeach
                                </select>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="phone">{{trans('languages.PHONE_NUMBER')}}<span>*</span></label>
                            <input type="text" class="form-control" id="phone" autocomplete="off" name="phone_number"
                                   required>
                        </div>
                    </div>
                    <div class="form-wrap">
                        <div class="form-group">
                            <label for="email">Email<span>*</span></label>
                            <input type="email" class="form-control" id="email" autocomplete="off" name="email"
                                   required>
                        </div>

                        <div class="form-group">
                            <label for="visitors-number">{{trans('languages.NUMBER_OF_VISITORS')}}<span>*</span></label>
                            <input type="number" class="form-control" id="visitors-number" autocomplete="off"
                                   name="amount_visitor" required>
                        </div>
                    </div>
                    <div class="form-wrap">
                        <div class="form-group form-content">
                            <label for="content">{{trans('languages.NOTES')}}</label>
                            <textarea class="form-control" id="content" name="note"></textarea>
                        </div>
                    </div>
                    <div class="form-wrap">
                        <div class="form-group">
                            <input type="submit" class="common-btn" value="{{trans('languages.REGISTER')}}">
                        </div>
                    </div>
                </form>
                <div class="company-tour__info">
                    <p>{{trans('languages.CONTACT_SUPPORT')}}</p>
                    <p class="company-tour__phone">{{trans('languages.PHONE_NUMBER')}}: <span></span></p>
                    <p class="company-tour__email">Email: <span></span></p>
                </div>
            </div>
        </div>
    </div>
</div>