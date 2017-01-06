@extends('codex::base')


@push('title')
{{ config('codex.display_name') }}
@endpush

@push('meta')
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('vendor/codex') }}/img/favicons/apple-touch-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('vendor/codex') }}/img/favicons/apple-touch-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('vendor/codex') }}/img/favicons/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('vendor/codex') }}/img/favicons/apple-touch-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('vendor/codex') }}/img/favicons/apple-touch-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('vendor/codex') }}/img/favicons/apple-touch-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('vendor/codex') }}/img/favicons/apple-touch-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('vendor/codex') }}/img/favicons/apple-touch-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('vendor/codex') }}/img/favicons/apple-touch-icon-180x180.png">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="codex">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('vendor/codex') }}/img/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('vendor/codex') }}/img/favicons/android-chrome-192x192.png">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('vendor/codex') }}/img/favicons/favicon-16x16.png">
    <link rel="shortcut icon" href="{{ asset('vendor/codex') }}/img/favicons/favicon.ico">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="theme-color" content="#fff">
    <meta name="application-name" content="{{ config('codex.display_name') }}">
    <link rel="apple-touch-startup-image" media="(device-width: 320px) and (device-height: 480px) and (-webkit-device-pixel-ratio: 1)" href="{{ asset('vendor/codex') }}/img/favicons/apple-touch-startup-image-320x460.png">
    <link rel="apple-touch-startup-image" media="(device-width: 320px) and (device-height: 480px) and (-webkit-device-pixel-ratio: 2)" href="{{ asset('vendor/codex') }}/img/favicons/apple-touch-startup-image-640x920.png">
    <link rel="apple-touch-startup-image" media="(device-width: 320px) and (device-height: 568px) and (-webkit-device-pixel-ratio: 2)" href="{{ asset('vendor/codex') }}/img/favicons/apple-touch-startup-image-640x1096.png">
    <link rel="apple-touch-startup-image" media="(device-width: 375px) and (device-height: 667px) and (-webkit-device-pixel-ratio: 2)" href="{{ asset('vendor/codex') }}/img/favicons/apple-touch-startup-image-750x1294.png">
    <link rel="apple-touch-startup-image" media="(device-width: 414px) and (device-height: 736px) and (orientation: landscape) and (-webkit-device-pixel-ratio: 3)" href="{{ asset('vendor/codex') }}/img/favicons/apple-touch-startup-image-1182x2208.png">
    <link rel="apple-touch-startup-image" media="(device-width: 414px) and (device-height: 736px) and (orientation: portrait) and (-webkit-device-pixel-ratio: 3)" href="{{ asset('vendor/codex') }}/img/favicons/apple-touch-startup-image-1242x2148.png">
    <link rel="apple-touch-startup-image" media="(device-width: 768px) and (device-height: 1024px) and (orientation: landscape) and (-webkit-device-pixel-ratio: 1)" href="{{ asset('vendor/codex') }}/img/favicons/apple-touch-startup-image-748x1024.png">
    <link rel="apple-touch-startup-image" media="(device-width: 768px) and (device-height: 1024px) and (orientation: portrait) and (-webkit-device-pixel-ratio: 1)" href="{{ asset('vendor/codex') }}/img/favicons/apple-touch-startup-image-768x1004.png">
    <link rel="apple-touch-startup-image" media="(device-width: 768px) and (device-height: 1024px) and (orientation: landscape) and (-webkit-device-pixel-ratio: 2)" href="{{ asset('vendor/codex') }}/img/favicons/apple-touch-startup-image-1496x2048.png">
    <link rel="apple-touch-startup-image" media="(device-width: 768px) and (device-height: 1024px) and (orientation: portrait) and (-webkit-device-pixel-ratio: 2)" href="{{ asset('vendor/codex') }}/img/favicons/apple-touch-startup-image-1536x2008.png">
    {{--<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">--}}

    @if(isset($googleVerification))
        <meta name="google-site-verification" content="{{ $googleVerification }}">
    @endif

    @if(isset($googleAnalytics))
        <meta name="google-analytics" content="{{ $googleAnalytics }}">
    @endif

    @if(isset($facebookAppId))
        <meta property="fb:app_id" content="$facebookAppId">
    @endif
@endpush

@section('body-tag-styles', 'page-loading')


