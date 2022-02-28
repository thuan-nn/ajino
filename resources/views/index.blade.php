<!DOCTYPE html>
<!--[if lt IE 7]>
<html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="{{ str_replace('_', '-', $locale) }}"> <![endif]-->
<!--[if IE 7]>
<html class="no-js lt-ie9 lt-ie8" lang="{{ str_replace('_', '-', $locale) }}"> <![endif]-->
<!--[if IE 8]>
<html class="no-js lt-ie9" lang="{{ str_replace('_', '-', $locale) }}"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="{{ str_replace('_', '-', $locale) }}">
<!--<![endif]-->
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <meta http-equiv="Content-Language" content="en-us"/>
    @if ($meta && $meta['title'])
        <title>{{$meta['title']}} | Ajinomoto Vietnam</title>
        <meta property="og:title" content="{{strip_tags($meta['title'])}} | Ajinomoto Vietnam" />
    @else
        <title>@yield('title') Ajinomoto Vietnam</title>
    @endif

    <meta name="description" content="{{ $meta && $meta['description'] ? strip_tags($meta['description']) : '' }}"/>
    <meta property="og:description" content="{{$meta && $meta['description'] ? strip_tags($meta['description']) : ''}}" />
    <meta property="og:url" content="{{url()->current()}}" />
    <meta property="og:type" content="website" />

    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"/>
    <link rel="icon" type="image/x-icon"
          href="{{empty($favicon) ? asset('assets/img/favicon.ico') : $favicon[0]['url']}}">
    <meta name="loader" content="{{asset('assets/img/loading.gif')}}">
    <link rel="stylesheet" href="{{asset('css/main.css')}}"/>
    <link rel="stylesheet" href="{{asset('css/quill.core.css')}}"/>
    <script>
        var APP_URL = '{{ $appUrl }}'
    </script>

    @isset($getGeneralJs)
        {!! $getGeneralJs !!}
    @endisset
</head>

<body>
<!--header-->
@include('layouts.header')
<!--main-->
<main>
    @yield('main')
</main>

<!--footer-->
@include('layouts.footer')
<!--script-->

<!--[if lt IE 8]>
<p class="browserupgrade">
    You are using an <strong>outdated</strong> browser. Please
    <a href="http://browsehappy.com/">upgrade your browser</a> to improve
    your experience.
</p>
<![endif]-->
<script src="{{asset('js/vendor/jquery-2.2.4.min.js')}}"></script>
<script src="{{asset('js/vendor/swiper-bundle.min.js')}}"></script>
<script src="{{asset('js/vendor/bootstrap.min.js')}}"></script>
@yield('script')
<script src="{{asset('js/main.js')}}"></script>
<script src="https://sp.zalo.me/plugins/sdk.js"></script>
</body>
</html>
