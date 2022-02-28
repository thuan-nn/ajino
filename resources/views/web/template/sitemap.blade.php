@extends('index')
@section('title',$post->{'title:'.$locale}.' | ')
@section('main')
    @include('web.component.breadcrumb',['breadcrumbs'=>$breadcrumbs])
    <div class="sitemap container">
        <h2 class="title">{{$post->{'title:'.$locale} }}</h2>
        <ul>
            <li>
                <a href="{{route_ui('home', $locale)}}">{{trans('languages.HOME')}}</a>
            </li>
            @foreach($menuLinks as $menuLink)
                @include('web.component.submenu_sitemap',['menuLink'=>$menuLink])
            @endforeach
        </ul>
    </div>
@endsection
