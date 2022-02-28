@extends('index')
@section('title','Homepage')
@section('main')
    <!--Slide Home-->
    @if($banners)
        @include('web.component.banner_single',['banners' => $banners])
    @endif
    <!-- ./Slide Home -->
        @if(checkDisplayBanner($advertise))
            <div class="banner-advertise">
                <a href="{{ $advertise['advertise']['url'][$locale] ?? 'javascript:void(0)'}}" class="banner-advertise__url" target="{{  $advertise['advertise']['url'][$locale] ? '_blank' : '_self' }}">
                    <button href="javascript:void(0)" class="banner-advertise__btn"></button>
                    <img src="{{ getImageAdvertise($advertise['advertise_image_pc'][$locale]) }}" class="banner-advertise__image" />
                </a>
            </div>

            <div class="banner-advertise-small">
                <img src="{{ getImageAdvertise($advertise['advertise_image_small'][$locale]) }}" class="banner-advertise-small__image" />
            </div>

            <div class="banner-advertise-mobile">
                <a href="{{ $advertise['advertise']['url'][$locale] ?? 'javascript:void(0)' }}" class="banner-advertise-mobile__url" target="{{  $advertise['advertise']['url'][$locale] ? '_blank' : '_self' }}">
                    <button href="javascript:void(0)" class="banner-advertise-mobile__btn"></button>
                    <img src="{{ getImageAdvertise($advertise['advertise_image_mobile'][$locale]) }}" class="banner-advertise-mobile__image" />
                </a>
            </div>
        @endif

    @if($notices)
        <section class="top__notice">
            <div class="container">
                <h3>
                    <img src="{{asset('assets/img/icon-exclamation.svg')}}"
                         alt="icon"/>

                    {{$notices[$locale]['title']}}
                </h3>

                <p>{{$notices[$locale]['content']}}</p>
            </div>
        </section>
    @endif

    <div class="container">
        @isset($storyHome[$locale])
            <section class="top__story common-block-product">
                @isset($storyHome[$locale]['title'])
                    <h2>{{ $storyHome[$locale]['title']}}</h2>
                @endisset

                @isset($storyHome[$locale]['content'])
                    <p>{{$storyHome[$locale]['content']}}</p>
                @endisset

                @if (count($stories))
                    <div class="block-product-wrap">
                        @foreach($stories as $story)
                            @include('web.component.post_item',[
                                    'imagePath' => getImageUrl($story, getFileTypeThumbnail()),
                                    'postTitle' => $story->{'title:'.$locale},
                                    'postContent' => $story->{'description:'.$locale},
                                    'url' => getPostSlug($story),
                                    'postFeature' => false
                                ])
                        @endforeach
                    </div>

                    @if(isset($storyHome[$locale]['url']) && $storyHome[$locale]['url'])
                        <div class="text-center">
                            <a href="{{ $storyHome[$locale]['url'] }}"
                               class="btn common-btn">
                                {{trans('languages.SHOW_MORE')}}
                            </a>
                        </div>
                    @endif

                @endif
            </section>
        @endisset
    <!--Featured post-->

        @if ($featuredContents)
            <section class="common-block-product">
                <div class="block-product-wrap block-2-col">
                    @foreach(array_slice($featuredPosts,0,2) as $featuredPost)
                        @include('web.component.post_item', [
                            'imagePath' => getImageSetting($featuredPost),
                            'postTitle' => $featuredPost['translation'][$locale]['title'],
                            'postContent' => $featuredPost['translation'][$locale]['content'],
                            'hyperlink' => $featuredPost['translation'][$locale]['url'],
                            'postFeature' => false
                        ])
                    @endforeach
                </div>
                <div class="block-product-wrap">
                    @foreach(array_slice($featuredPosts,2) as $featuredPost)
                        @include('web.component.post_item',[
                            'imagePath' => getImageSetting($featuredPost),
                            'postTitle'=>$featuredPost['translation'][$locale]['title'],
                            'postContent'=>$featuredPost['translation'][$locale]['content'],
                            'hyperlink'=>$featuredPost['translation'][$locale]['url'],
                            'postFeature' => false
                        ])
                    @endforeach
                </div>
            </section>
        @endif
    <!--Featured content-->
        @if ($featuredPosts)
            <section class="top__feature common-block-product">
                <h2>{{trans('languages.FEATURE_CONTENT')}}</h2>
                <div class="block-product-wrap">
                    @foreach($featuredContents as $featuredContent)
                        @include('web.component.post_item',[
                             'imagePath' => getImageSetting($featuredContent),
                             'postTitle'=>$featuredContent['translation'][$locale]['title'],
                             'postContent'=>$featuredContent['translation'][$locale]['content'],
                             'hyperlink'=>$featuredContent['translation'][$locale]['url'],
                             'postFeature' => false
                         ])
                    @endforeach
                </div>
            </section>
        @endif
    </div>
    @isset($popup)
        @include('web.component.popup_homepage',['popup'=>$popup])
    @endisset
@endsection
