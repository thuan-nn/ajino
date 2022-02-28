<div class="footer__sitemap-in container">
    <nav class="footer__menu">
        <ul class="footer__menu-list">
            <li class="footer__menu-item">
                @isset($footerTopLeftMenu)
                    @include('layouts.components.child_menu_bottom',['footerTopMenus'=>$footerTopLeftMenu])
                @endisset
            </li>
            <li class="footer__menu-item">
                @isset($footerTopMiddleMenu)
                    @include('layouts.components.child_menu_bottom',['footerTopMenus'=>$footerTopMiddleMenu])
                @endisset
            </li>
            <li class="footer__menu-item">
                @isset($footerTopRightMenu)
                    @include('layouts.components.child_menu_bottom',['footerTopMenus'=>$footerTopRightMenu])
                @endisset
            </li>
            <li class="footer__menu-item">
                <p class="footer__sitemap-title">{{ trans('languages.SUBSCRIBE_AJINOMOTO') }}</p>
                <ul class="footer__sns">
                    @isset($socialNetwork)
                        @foreach ($socialNetwork as $key => $network)
                            @if($network && !empty($network))
                                <li class="footer__sns-item">
                                    <a class="footer__sns-link" target="_blank" rel="noopener" href="{{$network}}">
                                        <img class="footer__sns-image" src="{{asset('assets/img/icon-'.$key.'.svg')}}"
                                             alt="icon-{{ $key }}"/>
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    @endisset
                </ul>
                <div class="footer-add-menu">
                    <a href="{{isset($jpLinks) ? $jpLinks : 'javascript:void(0)'}}" class="footer-add-menu__link" target="_blank">日本語サイトは、こちら
                        <br/>({{trans('languages.JAPANESE_WEBSITE')}})
                        <img src="{{asset('assets/img/icon-group.svg')}}" alt="icon-group"/></a>
                </div>
            </li>
        </ul>
    </nav>
</div>
