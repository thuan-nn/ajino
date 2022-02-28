@extends('index')
@section('title',$page['title'].' | ')
@section('main')
    <!--Slide Single-->
    @if (count($page['images']))
        @include('web.component.image_cover',[
            'image' => getImagePathFromCollection($page, getFileTypeCover()),
            'title' => isset($page['title']) && $page['title'] ? $page['title'] : '',
            'description' =>  isset($page['description']) && $page['description'] ? $page['description'] : '',
        ])
    @endif

    <!--./Slide Single-->
    <div class="about__wrap">
        <section class="common-block-product container">
            @if (!count($page['images']))
                <h2 class="title">
                    {{$page['title'] }}
                </h2>
            @endif

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
                    {{$posts['total']}} - {{trans('languages.UMAMI_POSTS')}}
                </div>

                {{$posts['pagination']->links('web.component.paginate')}}
            </div>
        </section>
    </div>
@endsection