@extends('index')
@section('title','404 Not Found | ')
@section('main')
    <div class="breadcrumb">
        <ul class="container">
            <li><a href="{{route_ui('home', $locale)}}">{{trans('languages.HOME')}}</a></li>
            <li><a><span>{{trans('languages.NOT_FOUND')}}</span></a></li>
        </ul>
    </div>
    <div class="error404 container">
        <h2 class="title">{{trans('languages.NOT_FOUND')}}</h2>

        <h3>
            {{trans('languages.NOT_FOUND_APOLOGY')}}
        </h3>

        <p>
            {{trans('languages.NOT_FOUND_CONTENT')}}
        </p>

        <ul>
            <li><a href="{{ route_ui('home', $locale) }}">{{trans('languages.HOME')}}</a></li>

            @if($sitemap)
                <li>
                    <a href="{{route_ui('posts.post.show', [ 'locale' => $locale, 'post' => getPostSlug($sitemap)])}}">
                        {{$sitemap->{'title:'.$locale} }}
                    </a>
                </li>
            @endif
            <li><a href="javascript:history.back();">{{trans('languages.BACK_PAGE')}}</a></li>
        </ul>
    </div>
@endsection