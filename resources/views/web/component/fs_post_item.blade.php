@php
    /**
     * @var $url
     * @var $locale
     * @var \App\Models\Post $post
     */
        $slug = '#';

        if (isset($url) && $url) {
            $slug = route_ui('posts.post.show', ['locale' => $locale, 'post' => $url]);
        }

        if (isset($post) && $post) {
            if (isset($post->{'additional:'. $locale}['is_link']) &&
            $post->{'additional:'. $locale}['is_link'] &&
            isset($post->{'additional:'. $locale}['custom_link']) &&
            $post->{'additional:'. $locale}['custom_link'])
            $slug = $post->{'additional:'. $locale}['custom_link'];
        }

        if (isset($hyperlink) && $hyperlink) {
            $slug = $hyperlink;
        }
@endphp

<a href="{{ $slug }}"
   class="item">

    <div class="{{ $postFeature ? 'item__thumb-feature' : 'item__thumb' }} " style="background-image: url('{{$imagePath}}')"></div>




    <div class="item__content">
        <h3 class="fs-product-item__content-title">
            {{$postTitle}}

            @isset($post->{'additional:'. $locale}['is_video'])
                @if ($post->{'additional:'. $locale}['is_video'])
                    <span class="movie-icon"></span>
                @endif
            @endisset
        </h3>

        <p>{{$postContent}}</p>
    </div>
</a>
