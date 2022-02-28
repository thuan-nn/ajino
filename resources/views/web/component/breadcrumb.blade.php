<div class="breadcrumb">
    <ul class="container">
        @foreach($breadcrumbs as $breadcrumb)
            @if($breadcrumb['route'] === request()->url())
                <li><span>{{$breadcrumb['title']}}</span></li>
            @else
                <li><a href="{{$breadcrumb['route']}}">{{$breadcrumb['title']}}</a></li>
            @endif
        @endforeach
    </ul>
</div>