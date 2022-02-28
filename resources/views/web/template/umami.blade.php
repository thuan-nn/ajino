@extends('index')
@section('title', $page->{'title:'.$locale}.' | ')
@section('main')

    @if($isMultipleTypeSlide)
        @include('web.component.banner_multiple', ['banners' => $banners['items']])
    @elseif($isSingleTypeSlide)
        @include('web.component.banner_single', ['banners' => $banners['items']])
    @else
        @include('web.component.image_cover',[
            'image' => getImageUrl($page, getFileTypeCover()),
            'title' => $page->{'title:'.$locale},
            'description' => $page->{'description:'.$locale},
        ])
    @endif

    @if($categories)
        <div class="umami umami__wrap container">
            @foreach($categories as $category)
                <section class="common-block-product">
                    <h3>{{$category->title}}</h3>

                    <div class="block-product-wrap">
                        @foreach($category->posts as $post)
                            @include('web.component.post_item', [
                                'imagePath' => getImageUrl($post, getFileTypeThumbnail()),
                                'postTitle' => $post->{'title:'.$locale},
                                'postContent' => $post->{'description:'.$locale},
                                'url' => getPostSlug($post),
                                'post' => $post,
                                'postFeature' => false
                            ])
                        @endforeach
                    </div>
                    @if(count($category->posts) > 6)
                        <div class="text-center">
                            <a class="btn common-btn"
                               href="{{route_ui('taxonomy.show', [
                                'locale' => $locale,
                                'post' => $page->{'slug:'.$locale},
                                'taxonomy' => $category->{'slug:'.$locale}])}}">
                                {{trans('languages.SHOW_MORE')}}
                            </a>
                        </div>
                    @endif
                </section>
            @endforeach
        </div>
    @endif
@endsection