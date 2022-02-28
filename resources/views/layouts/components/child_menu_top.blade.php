<!-- Header submenu -->
<div class="header__submenu header__submenu-block">
    <div class="header__submenu-wrap">
        <a class="header__submenu-title"
           href="{{getUrlMenuLinks($parentMenu)}}">
            {{ $parentMenu->{'title:'. $locale} }}
        </a>

        <ul class="header__submenu-list">
            @if($children = $parentMenu->children)
                @foreach($children as $menuChild)
                    <li class="header__submenu-item">
                        @php
                            /** @var mixed $menuChild */
                            $isHasChildren = $menuChild->children->count();
                        @endphp

                        <a class="header__submenu-link {{$isHasChildren ? "js-toggle js-submenu" : ""}}"
                           href="{{getUrlMenuLinks($menuChild)}}" {{$isHasChildren ? "data-group=submenu role=button" :""}}>
                            {{ $menuChild->{'title:'. $locale} }}
                        </a>

                        @if ($subChildren = $menuChild->children)
                            @foreach($subChildren as $submenuChild)
                                @include('layouts.components.child_submenu_top',['parentMenu' => $menuChild, 'menuChild' => $submenuChild])
                            @endforeach
                        @endif
                    </li>
                @endforeach
            @endif
        </ul>

        @if($parentMenu->parent === null)
            <button type="button"
                    class="header__submenu-close js-submenu-close"
                    aria-label="Close navigation">
            </button>
        @endif
    </div>
</div>
<!-- ./Header submenu -->