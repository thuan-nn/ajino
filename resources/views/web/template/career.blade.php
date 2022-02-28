@extends('index')
@section('title', $page['title'].' | ')
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
        <form method="GET"
              action="{{route_ui('posts.career.search', ['locale' => $locale, 'post' => $page['slug']])}}"
              class="career__form common-form container" id="form-career">
            <div class="form-group">
                <label for="keyword">{{trans('languages.KEY')}}</label>

                <input type="text" id="keyword" class="form-control" name="key" autocomplete="off">
            </div>

            @isset($locations)
                <div class="form-group">
                    {{--<label for="location">{{trans('languages.PLACE')}}</label>--}}
                    <select id="location" class="form-control" required name="place">
                        <option value="" class="first" selected disabled>{{trans('languages.PLACE')}}</option>

                        @foreach($locations as $location)
                            <option value="{{$location->id}}"> {{$location->display_name}} </option>
                        @endforeach
                    </select>
                </div>
            @endisset

            <input type="submit" class="common-btn" value="{{trans('languages.SEARCH')}}">
        </form>
    </div>
    <!--./Career search-->
    <div class="career career__wrap container">
        <section class="common-block-product career__hot">
            <h3>{{trans('languages.NEW_JOBS')}}</h3>

            <div class="block-product-wrap">
                @foreach($newJobs['data'] as $key => $job)
                    <a class="item item--bg"
                       href="{{route_ui('job.show', ['locale' => $locale, 'job' => $job->{'slug:'.$locale}])}}">
                        <div class="item__thumb"
                             style="background-image: url('{{getImageUrl($job, getFileTypeThumbnail())}}')"></div>

                        <div class="item__content">
                            <h3>{{ $job->{'title:'.$locale} }}</h3>

                            <p>
                                <span style="background: url({{asset('/assets/img/icon-location-white.svg')}}) no-repeat;"></span>
                                {{optional($job->location)->display_name}}
                            </p>
                            <p>
                                <span
                                    style="background: url({{asset('/assets/img/icon-position-white.svg')}}) no-repeat;"></span>
                                {{ $job->{'job_type:'.$locale} }}
                            </p>
                        </div>
                    </a>
                @endforeach
            </div>
        </section>

        @if ($jobs['data'])
            <section class="common-block-product">
                <h3>{{trans('languages.JOBS')}}</h3>

                <div class="block-product-wrap">
                    @foreach($jobs['data'] as $job)
                        <a class="item"
                           href="{{ route_ui('job.show', [
                                'locale' => $locale,
                                'job'=> $job->{'slug:'.$locale} ])}}">
                            <div class="item__content">
                                <h3>{{ $job->{'title:'.$locale} }}</h3>

                                <p>
                                    <span
                                        style="background: url({{asset('/assets/img/icon-location-gray.svg')}}) no-repeat;"></span>
                                    {{$job->location->display_name}}
                                </p>
                                <p>
                                    <span
                                        style="background: url({{asset('/assets/img/icon-position-gray.svg')}}) no-repeat;"></span>
                                    {{ $job->{'job_type:'.$locale} }}
                                </p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </section>


            <div class="common-pagination container">
                <div class="page-total">
                    {{$jobs['total']}} - {{trans('languages.CAREER_OPPORTUNITIES')}}
                </div>

                {{$jobs['pagination']->links('web.component.paginate')}}
            </div>

            <div class="post-container">
                <h3>{{trans('languages.ACTIVITY')}}</h3>

                {!! renderHtmlPreTag($page['content']) !!}
            </div>
        @endif
    </div>
@endsection
