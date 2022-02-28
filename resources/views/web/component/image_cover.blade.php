@if($image)
    <div class="slide slide-single swiper-container">
        <div class="swiper-wrapper">
            <!-- Slide item -->
            <a href="#" class="slide__item swiper-slide">
                <img class="slide__img"
                     src="{{$image}}"
                     width="1920"
                     height="910"
                     alt="image slide">

                <div class="slide__card container">
                    <p class="slide__card-title">{{$title}}</p>
                    <p class="slide__card-text">{{$description}}</p>
                </div>
            </a>
            <!--./Slide item -->
        </div>
    </div>
@endif