@if($banners)
    <div class="slide slide-top swiper-container">
        <div class="swiper-wrapper">
            @foreach($banners as $banner)
                @if($banner['type'] === \App\Enums\BannerType::IMAGE)
                    <a href="{{ $banner['url'] }}" class="swiper-slide slide__item">
                        <img class="slide__img" src="{{{getImagePathFromCollection($banner, getFileTypeThumbnail())}}}"
                             alt="image"
                             width="1920"
                             height="910">
                        @if( ($banner['title'] !== null) || ($banner['description'] !== null))
                            <div class="slide__card container">
                                <p class="slide__card-title">{{ $banner['title'] }}</p>
                                <p class="slide__card-text">{!! $banner['description'] !!}</p>
                            </div>
                        @endif
                    </a>
                @else
                    <a href="{{ $banner['url'] }}" class="swiper-slide slide__item youtube">
                        <iframe id="video-player" class="slide-media" width="1920" height="910"
                                src="{{ $banner['video_url'] }}"
                                frameborder="0" allow="encrypted-media" allowfullscreen></iframe>
                    </a>
                @endif
            @endforeach
        </div>
        <!-- Add Pagination -->
        <div class="swiper-pagination slide__pagination"></div>
        <!-- Add Arrows -->
        <div class="swiper-button-next slide__arrow"></div>
        <div class="swiper-button-prev slide__arrow"></div>
    </div>
@endif