@extends('index')
@section('title',$page['title'].' | ')
@section('main')

    @if($isMultipleTypeSlide)
        @include('web.component.banner_multiple',['banners' => $banners['items']])
    @elseif($isSingleTypeSlide)
        @include('web.component.banner_single',['banners' => $banners['items']])
    @else
        @include('web.component.image_cover',[
            'image' => getImagePathFromCollection($page, getFileTypeCover()),
            'title' => $page['title'],
            'description' => $page['description'],
        ])
    @endif

    <div class="about__wrap">
        @if($posts['data'])
            <section class="top__story common-block-product container">
                <div class="block-product-wrap">
                    @foreach($posts['data'] as $post)
                        @include('web.component.post_item', [
                            'imagePath' => getImageUrl($post, getFileTypeThumbnail()),
                            'postTitle' => $post->{'title:'.$locale},
                            'postContent' => $post->{'description:'.$locale},
                            'url' => getPostSlug($post),
                            'postFeature' => false
                        ])
                    @endforeach
                </div>
                <div class="common-pagination">
                    <div class="page-total">
                        {{$posts['total']}} - {{trans('languages.STORY_GROUP_PAGE')}}
                    </div>

                    {{$posts['pagination']->links('web.component.paginate')}}
                </div>
            </section>
        @endif
    </div>
@endsection