@extends('index')
@section('title',$page->{'title:'.$locale}.' | ')
@section('main')
    @if($isMultipleTypeSlide)
        @include('web.component.banner_multiple',['banners' => $banners['items']])
    @elseif($isSingleTypeSlide)
        @include('web.component.banner_single',['banners' => $banners['items']])
    @else
        @include('web.component.image_cover',[
            'image' => getImageUrl($page, getFileTypeCover()),
            'title' => $page->{'title:'.$locale},
            'description' => $page->{'description:'.$locale},
        ])
    @endif
    <!-- ./Slide Product -->
    <div class="product container">
        <h2 class="title">{{$page->{'title:'.$locale} }}</h2>

        <div class="product__content">
            {!! renderHtmlPreTag($page->{'content:'.$locale}) !!}

            <div class="common__category">
                <ul>
                    <li>
                        <a href="javascript:void(0)"
                           data-url="{{ route_ui('posts.category.filter',['locale'=> $locale, 'post'=> $page->{'slug:'.$locale}]) }}"
                           data-value=""
                           data-page="{{\App\Enums\PostTypeEnum::PRODUCT}}"
                           data-type="{{\App\Enums\TaxonomyEnum::CATEGORY}}">
                            {{trans('languages.ALL')}}
                        </a>
                    </li>
                    @if($categories)
                        @foreach($categories as $category)
                            <li>
                                <a href="javascript:void(0)"
                                   data-url="{{route_ui('posts.category.filter',['locale' => $locale, 'post' => $page->{'slug:'.$locale}]) }}"
                                   data-value="{{ $category->{'slug:'.$locale} }}"
                                   data-page="{{ $category->page }}"
                                   data-type="{{ $category->type }}"
                                   class="{{$taxonomy->id === $category->id ? 'active' : ''}}">
                                    {{ $category->{'title:'.$locale} }}
                                </a>
                            </li>
                        @endforeach
                    @endif
                </ul>
            </div>
            <div id="product-content">
                <section class="common-block-product product--loading">
                    <div id="loading" class="text-center">
                        <img style="width: 50px; height:auto" src="{{asset('/assets/img/loading.gif')}}"
                             alt="image loading">
                    </div>

                    <div class="block-product-wrap block-4-col" id="product-list"></div>
                </section>

                <div class="common-pagination">
                    <div class="page-list"></div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{asset('js/script.js')}}"></script>
@endsection
