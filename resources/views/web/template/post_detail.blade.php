@extends('index')
@section('title', $postDetail->{'title:'.$locale}.' | ')

@section('main')
    @if(!$coverUrl)
        @include('web.component.breadcrumb', ['breadcrumbs' => $breadcrumbs])
    @endif

    <!--Slide Single-->
    @if($coverUrl)
        @include('web.component.image_cover',[
            'image' => $coverUrl,
            'title' => $postDetail->{'title:'.$locale} ,
            'description' => $postDetail->{'description:'.$locale},
        ])
    @endif
    <!--./Slide Single-->

    <div class="stories stories-detail container">
        @if(!$coverUrl && $thumbnailUrl)
            <h2 class="title">
                {{$postDetail->{'title:'.$locale} }}
            </h2>
        @endif

        <div class="common__follows {{ !$coverUrl ? 'common__follows--right' : ''}}">
            <a href="https://www.facebook.com/sharer/sharer.php?u={{request()->url()}}">
                <img src="{{asset('assets/img/icon-facebook.png')}}" alt="icon facebook">
            </a>

            <a class="zalo-share-button"
               data-href="{{request()->url()}}"
               data-oaid="1331366046186962384"
               data-layout="2"
               data-color="blue"
               data-customize=true>
                <img class="img-mxh"
                     src="{{asset('assets/img/icon-zalo.svg')}}"
                     width="32"
                     height="32"/>
            </a>
        </div>

        <div class="post-container">
            {!! renderHtmlPreTag($postDetail->{'content:'.$locale}) !!}

            @if($filePaths)
                @if($fileListTitle)
                    <div class="product__content-block" style="margin-top: 40px">
                        <h3>
                            {{$fileListTitle}}
                        </h3>
                    </div>
                @else
                    <p>&nbsp;</p>
                @endif

                @foreach($filePaths as $index => $filePath)
                    <p class="text-primary">
                        {{$index + 1}}.<a class="text-primary" href="{{$filePath['url']}}" target="_blank">{{$filePath['name']}}</a>
                    </p>
                @endforeach
            @endif
        </div>

        <section class="common-block-product featured mt-5">
            <h3>{{trans('languages.FEATURE_CONTENT')}}</h3>

            <div class="block-product-wrap">
                @foreach($featuredPosts as $featuredPost)
                    @include('web.component.post_item', [
                        'imagePath' => getImageUrl($featuredPost, getFileTypeThumbnail()),
                        'postTitle' => $featuredPost->{'title:'. $locale},
                        'postContent' => $featuredPost->{'description:'. $locale},
                        'url' => getPostSlug($featuredPost),
                        'post' => $featuredPost,
                        'postFeature' => true
                    ])
                @endforeach
            </div>
        </section>
    </div>
@endsection
