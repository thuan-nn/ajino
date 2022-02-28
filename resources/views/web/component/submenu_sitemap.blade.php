<li>
    <a href="{{getUrlMenuLinks($menuLink)}}">
        {{$menuLink->{'title:'. $locale} }}
    </a>

    <ul class="sub-menu">
        @foreach($menuLink->children as $menu_child)
            @include('web.component.submenu_sitemap', ['menuLink'=>$menu_child])
        @endforeach
    </ul>
</li>