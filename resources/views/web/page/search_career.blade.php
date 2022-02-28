@extends('index')
@section('title', $page->{'title:'.$locale}.' | ')
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

    <!--Career search-->
    <div class="career__search">
        <form id="form-career" class="career__form common-form container"
              action="{{route_ui('posts.career.search', ['locale' => $locale, 'post' => $page])}}"
              method="GET">
            <div class="form-group">
                <label for="keyword">{{trans('languages.KEY')}}</label>

                <input type="text"
                       id="keyword"
                       class="form-control"
                       autocomplete="off"
                       value="{{isset($searchData['key']) ? $searchData['key'] : ''}}"
                       name="key">
            </div>
            <div class="form-group">
                <label for="location">{{trans('languages.PLACE')}}</label>

                <select class="form-control" required name="place">
                    <option value="" class="first" selected hidden disabled></option>

                    @foreach($locations as $location)
                        <option value="{{$location->id}}"
                            {{(isset($searchData['place']) && $searchData['place'] === $location->id) ? 'selected' : ''}}>
                            {{$location->name}}
                        </option>
                    @endforeach
                </select>
            </div>
            <input type="submit" class="common-btn" value="{{trans('languages.SEARCH')}}">
        </form>
    </div>
    <!--./Career search-->
    <div class="career career__wrap container">
        <section class="common-block-product">
            <h3>{{$jobs['total']}} {{trans('languages.POSITION')}}</h3>

            <div class="block-product-wrap">
                @foreach($jobs['data'] as $job)
                    <a class="item"
                       href="{{route_ui('job.show', [
                                'locale' => $locale,
                                'job' => $job->{'slug:'.$locale}
                            ])}}">
                        <div class="item__content">
                            <h3>{{$job->{'title:'.$locale} }}</h3>

                            <p>
                                <span
                                    style="background: url({{asset('assets/img/icon-location-gray.svg')}}) no-repeat;"></span>
                                {{optional($job->location)->name}}
                            </p>

                            <p>
                                <span
                                    style="background: url({{asset('assets/img/icon-position-gray.svg')}}) no-repeat;"></span>

                                {{$job->{'job_type:'.$locale} }}
                            </p>
                        </div>
                    </a>
                @endforeach
            </div>
        </section>

        <div class="common-pagination container">
            {{$jobs['pagination']->links('web.component.paginate')}}
        </div>

    </div>
@endsection
