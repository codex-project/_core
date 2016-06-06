@extends('codex::layouts.base')

@push('meta')
<meta name="description" content="{{ config('codex.display_name') }}.">
<meta name="keywords" content="laravel, php, framework, web, artisans, taylor otwell">
<meta name="viewport" content="width=device-width, initial-scale=1">
@endpush

@section('stylesheets')
    @parent
    <!--[if lte IE 9]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <link rel="apple-touch-icon" href="{{ asset('vendor/codex/favicon.png') }}">
@show



@section('body')
    <nav class="main" data-layout="nav">
        <a href="/" class="brand">
            {{--<img src="{{ $assetPath }}/img/laravel-logo.png" height="30" alt="Laravel logo">--}}
            {{ config('codex.display_name') }}
        </a>

        @stack('header')

    </nav>

    <!-- CONTENT -->
    <div class="docs-wrapper" data-layout="wrapper">
        @stack('content')
    </div>
    <!-- CONTENT:END -->

    @stack('footer')

@stop
