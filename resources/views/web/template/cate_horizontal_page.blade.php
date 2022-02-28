@extends('index')
@section('title',$post->{'title:'.$locale}.' | ')
@section('main')
    @if ($banners)
        @if($isMultipleTypeSlide)
            @include('web.component.banner_multiple',['banners' => $banners['items']])
        @elseif($isSingleTypeSlide)
            @include('web.component.banner_single',['banners' => $banners['items']])
        @else
            @include('web.component.image_cover',[
                'image' => getImageUrl($post,getFileTypeCover()),
                'title' => $post->{'title:'.$locale},
                'description' => $post->{'description:'.$locale},
            ])
        @endif
    @endif
    <div class="product container">
        <h2 class="title">{{$post->{'title:'.$locale} }}</h2>

        <div class="product__content">
            {!! renderHtmlPreTag($post->{'content:'.$locale}) !!}

            <div class="common__category">
                <ul>
                    <li>
                        <a href="javascript:void(0)"
                           data-url="{{route_ui('posts.category.filter', ['locale'=>$locale,'post'=>$post->{'slug:'.$locale}])}}"
                           data-value=""
                           class="active">{{trans('languages.ALL')}}</a>
                    </li>
                    @if($categories)
                        @foreach($categories as $category)
                            <li>
                                <a href="javascript:void(0)"
                                   data-url="{{route_ui('posts.category.filter',['locale' => $locale, 'post' => $post->{'slug:'.$locale}])}}"
                                   data-value="{{$category->{'slug:'.$locale} }}">
                                    {{$category->{'title:'.$locale} }}
                                </a>
                            </li>
                        @endforeach
                    @endif
                </ul>
            </div>
            <section class="common-block-product product--loading">
                <div id="loading"><img src="{{asset('/assets/img/loading.gif')}}" alt="image loading"></div>
                <div class="block-product-wrap block-4-col" id="product-list">
                </div>
            </section>
            <div class="common-pagination">
                <div class="page-list"></div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{asset('js/script.js')}}"></script>
@endsection