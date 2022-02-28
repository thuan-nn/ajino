@extends('index')
@section('title',$post->{'title:'.$locale}.' | ')
@section('main')
    @include('web.component.breadcrumb',['breadcrumbs'=>$breadcrumbs])
    <div class="umami umami-recipies container">
        <h2 class="title">{{$post->{'title:'.$locale} }}</h2>
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

            @if ($postFeatures)
                <div class="block-product-wrap block-2-col">
                    @foreach($postFeatures as $postFeature)
                        @include('web.component.post_item',[
                            'imagePath' => getImagePath($postFeature, getFileTypeThumbnail()),
                            'postTitle' => $postFeature->{'title:'.$locale},
                            'postContent' => $postFeature->{'description:'. $locale},
                            'url' => getPostSlug($postFeature),
                            'postFeature' => true
                        ])
                    @endforeach
                </div>
            @endif
        </section>
        <section class="common-block-product">
            <h3>{{$postRecipes->total()}} Recipes</h3>

            @if ($postRecipes)
                <div class="block-product-wrap">
                    @foreach($postRecipes as $postRecipe)
                        @include('web.component.post_item',[
                            'imagePath' => getImagePath($postRecipe, getFileTypeThumbnail()),
                            'postTitle' => $postRecipe->{'title:'.$locale},
                            'postContent' => $postRecipe->{'description:'. $locale},
                            'url' => getPostSlug($postRecipe),
                            'postFeature' => false
                        ])
                    @endforeach
                </div>
            @endif
        </section>

        <div class="common-pagination">
            {{$postRecipes->links('web.component.paginate')}}
        </div>
    </div>
@endsection