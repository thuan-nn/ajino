<header id="header" class="header">
    <!--Header top-->
    <div class="header__top header__top--mobile container">
        @if(isset($slogan[$locale]) && $slogan[$locale])
            <p class="header__name">
                {{$slogan[$locale]}}
            </p>
        @endif
    </div>
<!--./Header top-->
    <!--Header search-->
    <div class="header__search">
        <div class="header__search-wrap container">
            <form class="header__search-form" action="{{route_ui('post.search',['locale'=>$locale])}}" method="GET"
                  role="{{trans('languages.SEARCH')}}">
                <input class="header__search-input" type="text" title="{{trans('languages.SEARCH_TITLE_INPUT')}}"
                       placeholder="{{trans('languages.SEARCH')}}"
                       tabIndex="0" name="post"/>
                <button class="header__search-btn" type="submit">{{trans('languages.SEARCH_BUTTON')}}</button>
            </form>
            <button class="header__search-close js-search-close" type="button" aria-label="Close search"></button>
        </div>
    </div>
    <!--Header search-->
    <!--Header main-->
    <div class="header__wrap container">
        <!--logo-->
        <a href="{{route_ui('home', $locale)}}" class="header__logo">
            <img src="{{empty($logo) ? asset('assets/img/logo.svg') : $logo[0]['url']}}"
                 alt="-Eat Well, Live Well.- AJINOMOTO"/>
        </a>
        <!--./logo-->
        <!--Header content-->
        <div class="header__contents">
            <div class="header__contents--top">
                <!--Header top-->
                <div class="header__top header__top--desktop">
                    @if(isset($slogan[$locale]) && $slogan[$locale])
                        <p class="header__name">
                            {{$slogan[$locale]}}
                        </p>
                    @endif
                </div>
                <!--./Header top-->
                <!--Header utility-->
                <ul class="header__utility-list">
                    <li class="header__utility-item">
                        <a href="{{isset($globalLinks['link']) ? $globalLinks['link'] : 'javascript:void(0)'}}"
                           class="header__utility-link header__utility-link--global"
                           target="_blank">
                        <span class="header__utility-text">
                            {{isset($globalLinks['translation'][$locale]) ? $globalLinks['translation'][$locale] : '' }}
                        </span>
                        </a>
                    </li>
                    <li class="header__utility-item">
                        <a href="https://www.ajinomoto.com/aboutus/group/global_network"
                           class="header__utility-link header__utility-link--world">
                            <span class="header__utility-text">{{trans('languages.COUNTRY_REGION')}}</span>
                        </a>
                    </li>
                    <li class="header__utility-item header__lang">
                        <a href="javascript:void(0)" class="header__lang-current">
                            {{strtoupper($locale)}}
                        </a>

                        <nav class="header__lang-list">
                            @if($languages = \App\Enums\LanguageEnum::asArray())
                                @foreach($languages as $language)
                                    <a class="header__lang-link"
                                       title="{{strtoupper($language)}}"
                                       href="{{urlReplaceLocale($locale, $language)}}">
                                        {{strtoupper($language)}}
                                    </a>
                                @endforeach
                            @endif
                        </nav>
                    </li>
                    <li class="header__utility-item">
                        <button type="button" class="header__utility-link header__utility-link--search js-search">
                            <span class="header__utility-text">{{trans('languages.SEARCH')}}</span>
                        </button>
                    </li>
                    <li class="header__utility-item header__utility-item--trigger">
                        <button type="button"
                                class="header__utility-link header__utility-link--menu js-menu"
                                aria-label="Menu mobile">
                        </button>
                    </li>
                </ul>
                <!--./Header utility-->
            </div>

            <!--Header nav-->
            <nav id="global-nav" class="header__nav">
                <div class="header__nav-wrap">
                    @include('layouts.components.main_menu', ['mainLeftMenu'=> $mainLeftMenu, 'mainRightMenu'=> $mainRightMenu])
                </div>

                <button type="button" class="header__nav-close js-close" aria-label="Close global nav"></button>
                <button type="button" class="header__nav-back js-back">{{trans('languages.BACK')}}</button>
            </nav>
            <!--./Header nav-->
        </div>
        <!--./Header content-->
    </div>
    <!--./Header main-->
</header>
