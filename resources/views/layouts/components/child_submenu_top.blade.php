<div class="header__submenu">
    <a class="header__submenu-title" href="{{getUrlMenuLinks($parentMenu)}}">
        {{ $parentMenu->{'title:'. $locale} }}
    </a>

    <ul class="header__submenu-list">
        @if ($children = $parentMenu->children)
            @foreach($children as $menuChild)
                <li class="header__submenu-item">
                    @php
                        /** @var mixed $menuChild */
                        $isHasChildren = $menuChild->children->count()
                    @endphp

                    <a class="header__submenu-link {{$isHasChildren ? "js-toggle js-submenu" : ""}}"
                       {{$isHasChildren ? "data-group=submenu role=button" :""}}
                       href="{{getUrlMenuLinks($menuChild)}}">
                        {{ $menuChild->{'title:'. $locale} }}
                    </a>

                    @if ($subChildren = $menuChild->children)
                        @foreach($subChildren as $submenuChild)
                            @include('layouts.components.child_submenu_top', ['parentMenu' => $menuChild, 'menuChild' => $submenuChild])
                        @endforeach
                    @endif
                </li>
            @endforeach
        @endif
    </ul>
</div>