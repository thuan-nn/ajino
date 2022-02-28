@extends('index')
@section('title',$page->{'title:'.$locale}.' | ')
@section('main')
    @include('web.component.breadcrumb', ['breadcrumbs' => $breadcrumbs])

    <div class="umami umami-recipies container">
        <h2 class="title">{{$page->{'title:'.$locale} }}</h2>
        <div class="common__follows">
            <a href="https://www.facebook.com/sharer/sharer.php?u={{request()->url()}}">
                <img src="{{asset('assets/img/icon-facebook.png')}}" alt="icon facebook">
            </a>
            <a class="zalo-share-button"
               data-href="{{request()->url()}}" data-oaid="1331366046186962384"
               data-layout="2" data-color="blue" data-customize=true>
                <img class="img-mxh"
                     src="{{asset('assets/img/icon-zalo.svg')}}"
                     width="32" height="32">
            </a>
        </div>
        <section class="common-block-product">
            <h3>Currently we love...</h3>

            @if ($features)
                <div class="block-product-wrap block-2-col">
                    @foreach($features as $feature)
                        @include('web.component.post_item',[
                            'imagePath' => getImageUrl($feature, getFileTypeThumbnail()),
                            'postTitle' => $feature->{'title:'.$locale},
                            'postContent' => $feature->{'description:'. $locale},
                            'url' => getPostSlug($feature),
                            'postFeature' => true
                        ])
                    @endforeach
                </div>
            @endif
        </section>
        <section class="common-block-product">
            <h3>{{$recipes->total()}} {{trans('languages.UMAMI_POSTS')}}</h3>

            @if ($recipes)
                <div class="block-product-wrap">
                    @foreach($recipes as $recipe)
                        @include('web.component.post_item',[
                            'imagePath' => getImageUrl($recipe, getFileTypeThumbnail()),
                            'postTitle' => $recipe->{'title:'.$locale},
                            'postContent' => $recipe->{'description:'. $locale},
                            'url' => getPostSlug($recipe),
                            'postFeature' => false
                        ])
                    @endforeach
                </div>
            @endif
        </section>

        <div class="common-pagination">
            {{$recipes->links('web.component.paginate')}}
        </div>
    </div>
@endsection