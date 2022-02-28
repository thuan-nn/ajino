<!--Slide Product-->
@if($banners)
    <div class="slide slide-carousel swiper-container">
        <div class="swiper-wrapper">
            @foreach($banners as $banner)
                @if($banner['type'] === \App\Enums\BannerType::IMAGE)
                    <a href="{{ $banner['url'] }}" class="swiper-slide slide__item">
                        <img class="slide__img" src="{{getImagePathFromCollection($banner, getFileTypeThumbnail())}}" alt="image">
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
<!-- ./Slide Product -->