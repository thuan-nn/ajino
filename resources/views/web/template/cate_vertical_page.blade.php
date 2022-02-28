@extends('index')
@section('title',$post->{'title:'.$locale}.' | ')
@section('main')
    @if($isMultipleTypeSlide)
        @include('web.component.banner_multiple',['banners' => $banners['items']])
    @elseif($isSingleTypeSlide)
        @include('web.component.banner_single',['banners' => $banners['items']])
    @else
        @include('web.component.image_cover',[
            'image' => getImageUrl($post, getFileTypeCover()),
            'title' => $post->{'title:'.$locale},
            'description' => $post->{'description:'.$locale},
        ])
    @endif
    <div class="umami umami__wrap container">
        @foreach($categories as $category)
            <section class="common-block-product">
                <h3>{{$category->{'title:'.$locale} }}</h3>

                <div class="block-product-wrap">
                    @php
                        /** @var mixed $category */
                        $firstCategories = $category->posts->where('parent_id', $post->id)->take(6);
                    @endphp

                    @foreach($firstCategories as $post_cate)
                        @include('web.component.post_item', [
                            'imagePath' => getImagePath($post, getFileTypeThumbnail()),
                            'postTitle' => $post_cate->translate($locale)->title,
                            'postContent' => $post_cate->translate($locale)->description,
                            'url' => getPostSlug($post_cate),
                            'postFeature' => false
                        ])
                    @endforeach
                </div>
                @if($firstCategories->count() === 6)
                    <div class="text-center">
                        <a href="{{route_ui('taxonomy.show',[
                            'locale' => $locale,
                            'post' => $post->{'slug:'.$locale},
                            'taxonomy' => $category->translate($locale)->slug])}}"
                           class="btn common-btn">{{trans('languages.SEE_MORE')}}</a>
                    </div>
                @endif
            </section>
        @endforeach
    </div>
@endsection