@extends('index')

@if ($postDetail)
    @section('title', $postDetail->{'title:'. $locale}.' | ')

@section('main')
    @if(!$coverUrl)
        @include('web.component.breadcrumb', ['breadcrumbs' => $breadcrumbs])

    @endif

    @if($isMultipleTypeSlide)
        @include('web.component.banner_multiple',['banners' => $banners['items']])
    @elseif($isSingleTypeSlide)
        @include('web.component.banner_single',['banners' => $banners['items']])
    @else
        @include('web.component.image_cover',[
            'image' => getImageUrl($postDetail, getFileTypeCover()),
            'title' => $postDetail->{'title:'. $locale},
            'description' => $postDetail->{'description:'.$locale},
        ])
    @endif

    @if($coverUrl)
        <div class="static-block container">
            <div class="block__content post-container">
                <div class="inner w-848">
                    {!! renderHtmlPreTag($postDetail->{'content:'. $locale}) !!}

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
            </div>
        </div>
    @else
        <div class="static-block container">
            <div class="inner w-848">
                <h2 class="title">{{$postDetail->{'title:'. $locale} }}</h2>

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

                <div class="block__content post-container">
                    {!! renderHtmlPreTag($postDetail->{'content:'. $locale}) !!}

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
            </div>
        </div>
    @endif
@endsection
@endif