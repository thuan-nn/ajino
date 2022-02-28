<footer>
    @if(isset($webLinks) && count($webLinks))
        <div class="slide-footer">
            <div class="slide swiper-container container">
                <h4>{{trans('languages.WEB_LINK')}}</h4>

                <div class="swiper-wrapper">
                    @foreach($webLinks as $webLink)
                        <a href="{{$webLink['translation'][$locale]['url']}}"
                           class="swiper-slide slide__item" target="_blank">
                            <img class="swiper__figure-image"
                                 src="{{getImageSetting($webLink)}}"
                                 alt="{{$webLink['translation'][$locale]['title']}}">

                            <div class="slide__card ">
                                <p class="slide__card-text">
                                    {{$webLink['translation'][$locale]['title']}}
                                </p>
                            </div>
                        </a>
                    @endforeach
                </div>
                <!-- Add Pagination -->
                <div class="swiper-pagination slide__pagination"></div>
                <!-- Add Arrows -->
                <div class="swiper-button-next slide__arrow"></div>
                <div class="swiper-button-prev slide__arrow"></div>
            </div>
        </div>
    @endif

    @if($footerTopLeftMenu && $footerTopMiddleMenu && $footerTopRightMenu)
        <div class="footer__sitemap">
            @include('layouts.components.footer_menu', [
                'footerTopLeftMenu' => $footerTopLeftMenu,
                'footerTopMiddleMenu'=> $footerTopMiddleMenu,
                'footerTopRightMenu' => $footerTopRightMenu
            ])
        </div>
    @endif

    @if($footerBottomMenu && $copyright)
        <div class="footer__bottom container">
            @include('layouts.components.footer_bottom', [
                'footerBottomMenus'=> $footerBottomMenu,
                'copyright'=> $copyright[$locale]
            ])
        </div>
    @endif
</footer>
