<ul class="footer__nav">
    @isset($footerBottomMenus)
        @foreach($footerBottomMenus as $footerBottomMenu)
            <li class="footer__nav-item">
                <a class="footer__nav-link" href="{{getUrlMenuLinks($footerBottomMenu)}}">
                    {{ $footerBottomMenu->{'title:'. $locale} }}
                </a>
            </li>
        @endforeach
    @endisset
</ul>

<p class="footer__copy">
    <small class="footer__copy-text">{{$copyright}}</small>
</p>