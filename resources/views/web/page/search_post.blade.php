@extends('index')
@section('title','Search | ')
@section('main')
    <div class="breadcrumb">
        <ul class="container">
            <li><a href="{{route_ui('home',$locale)}}">{{trans('languages.HOME')}}</a></li>
            <
            <li><a><span>{{trans('languages.SEARCH')}}</span></a></li>
        </ul>
    </div>
    <div class="search-page container">
        <h2 class="title">{{trans('languages.SEARCH')}}</h2>

        <div class="search-form">
            <form action="{{route_ui('post.search',['locale'=>$locale])}}" role="search">
                <input type="text"
                       title="Type search word here"
                       id="search-input"
                       name="post"
                       value="{{$searchData['post']}}"
                       placeholder="{{trans('languages.SEARCH')}}">

                <button type="submit">{{trans('languages.SEARCH')}}</button>
            </form>
        </div>

        <h3>{{trans('languages.RESULT_PAGE')}}</h3>

        @if(!count($listPost))
            <div class="search-status">
                <p class="pbox-search-status__error">{{trans('languages.PAGE_NON')}}</p>
            </div>
        @else
            <div class="search-result">
                <p class="search-result__text">{{trans('languages.RESULTS')}}
                    <span class="search-result__totalhits">{{$listPost->total()}}</span>
                </p>
            </div>

            <div class="search-record">
                @foreach($listPost as $post)
                    <div class="search-record__wrap record">
                        <div class="search-record__title">
                            <a href="{{route_ui('posts.post.show',['locale'=>$locale,'post'=>getPostSlug($post)])}}"
                               target="_self"
                               title="Umami Global Website | Ajinomoto Group Global Website - Eat Well, Live Well.">
                                {{$post->{'title:'.$locale} }}
                            </a>
                        </div>

                        <div class="search-record__nearby">
                            {{$post->{'description:'. $locale} }}
                        </div>

                        <div class="search-record__url">
                            <a href="{{route_ui('posts.post.show',['locale' => $locale, 'post'=>getPostSlug($post)])}}"
                               class="pbClick" target="_self"
                               title="{{ $post->{'title:'.$locale} }}">
                                {{ route_ui('posts.post.show',['locale' => $locale, 'post'=>getPostSlug($post)]) }}
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="common-pagination">
                {{$listPost->links('web.component.paginate')}}
            </div>
        @endif
    </div>
@endsection
