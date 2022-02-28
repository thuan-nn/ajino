@foreach($footerTopMenus as $footerTopMenu)
    <span class="footer__menu-trigger js-footer">
        <a class="footer__menu-link"
           href="{{getUrlMenuLinks($footerTopMenu)}}"
           role="button">
            {{ $footerTopMenu->{'title:'.$locale} }}
        </a>
    </span>

    <div class="footer__submenu">
        <div class="footer__submenu-in">
            <a class="footer__submenu-title"
               href="{{getUrlMenuLinks($footerTopMenu)}}">
                {{ trans('languages.HOME').' '.mb_strtolower($footerTopMenu->{'title:'.$locale}) }}
            </a>

            <ul class="footer__submenu-list">
                @if($children = $footerTopMenu->children)
                    @foreach($children as $footerTopMenuChild)
                        <li class="footer__submenu-item">
                            <a class="footer__submenu-link"
                               href="{{getUrlMenuLinks($footerTopMenuChild)}}">
                                {{ $footerTopMenuChild->{'title:'.$locale} }}
                            </a>
                        </li>
                    @endforeach
                @endif
            </ul>
        </div>
    </div>
@endforeach
