<ul class="header__menu">
    @isset($mainLeftMenu)
        @foreach($mainLeftMenu as $menuLeft)
            <li class="header__menu-item">
                @php
                /** @var mixed $menuLeft */
                $isHasChildren = $menuLeft->children->count();
                @endphp

                <a href="{{$isHasChildren ? 'javascript:void(0)' : getUrlMenuLinks($menuLeft)}}"
                   class="header__menu-link {{$isHasChildren ? "js-accordion" : ""}} "
                    {{$isHasChildren ? "data-group=menu role=button" :""}}>

                    {{ $menuLeft->{'title:'.$locale} }}
                </a>

                @if($isHasChildren)
                    @include('layouts.components.child_menu_top', ['parentMenu' => $menuLeft])
                @endif
            </li>
        @endforeach
    @endisset
</ul>

<ul class="header__info">
    @isset($mainRightMenu)
        @foreach($mainRightMenu as $menuRight)
            <li class="header__info-item">
                @php
                    /** @var mixed $menuRight */
                    $isHasChildren = $menuRight->children->count();
                @endphp

                <a href="{{$isHasChildren ? 'javascript:void(0)' : getUrlMenuLinks($menuRight)}}"
                   class="header__info-link {{$isHasChildren ? "js-accordion" : ""}} "
                    {{$isHasChildren ? "data-group=menu role=button" :""}}>

                    {{ $menuRight->{'title:'.$locale} }}
                </a>

                @if($isHasChildren)
                    @include('layouts.components.child_menu_top', ['parentMenu'=> $menuRight])
                @endif
            </li>
        @endforeach
    @endisset
</ul>