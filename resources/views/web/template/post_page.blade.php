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

    @isset ($postChildren)
        <div class="about__wrap">
            <section class="common-block-product container">
                <div class="block-product-wrap">
                    @foreach($postChildren as $post_child)
                        @include('web.component.post_item',[
                            'imagePath' => getImagePath($post_child, getFileTypeThumbnail()),
                            'postTitle' => $post_child->{'title:'.$locale},
                            'postContent' => $post_child->{'description:'. $locale},
                            'url' => getPostSlug($post_child),
                            'postFeature' => false
                        ])
                    @endforeach
                </div>
                <div class="common-pagination">
                    <div class="page-total">
                        {{$postChildren->total()}}
                    </div>

                    {{$postChildren->links('web.component.paginate')}}
                </div>
            </section>
        </div>
    @endisset
@endsection