<section class="common-block-product product--loading">
    @isset ($postChildren)
        <div class="block-product-wrap block-4-col">
            @foreach($postChildren as $post_child)
                @include('web.component.post_item',[
                    'imagePath' => getImagePath($post_child, getFileTypeThumbnail()),
                    'postTitle' => $post_child->{'title:'.$locale},
                    'postContent' => '',
                    'url' => getPostSlug($post_child),
                    'postFeature' => false
                ])
            @endforeach
        </div>
    @endisset
</section>

<div class="common-pagination">
    @isset ($postChildren)
        <div class="page-total">
            {{$postChildren->total()}} - {{ $title }}
        </div>
        <div class="page-list">
            {{$postChildren->links('web.component.paginate')}}
        </div>
    @endisset
</div>
