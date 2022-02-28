@extends('index')

@if ($post)
    @section('title', $post->{'title:'.$locale}.' | ')

@section('main')
    @include('web.component.breadcrumb', ['breadcrumbs' => $breadcrumbs])
    @if(getImagePath($post, getFileTypeCover()) !== '#')
        @include('web.component.image_cover',[
            'image' => getImageUrl($post, getFileTypeCover()),
            'title' => $post->{'title:'.$locale} ,
            'description' => $post->{'description:'.$locale},
        ])

        <div class="static-block container post-container">
            <div class="inner w-848">
                {!! renderHtmlPreTag($post->{'content:'.$locale}) !!}
            </div>
        </div>
    @else
        <div class="static-block container">
            <div class="inner w-848">
                <h2 class="title">{{$post->{'title:'.$locale} }}</h2>

                <div class="block__content post-container">
                    {!! renderHtmlPreTag($post->{'content:'.$locale}) !!}
                </div>
            </div>
        </div>
    @endif
@endsection
@endif