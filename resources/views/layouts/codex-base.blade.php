@extends('codex::layouts.base')

@push('meta')
<meta name="description" content="{{ config('codex.display_name') }}.">
<meta name="keywords" content="laravel, php, framework, web, artisans, taylor otwell">
<meta name="viewport" content="width=device-width, initial-scale=1">
@endpush

@push('stylesheets')
<!--[if lte IE 9]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="{{ asset('vendor/codex/styles/stylesheet.css') }}">
<link rel="apple-touch-icon" href="{{ asset('vendor/codex/favicon.png') }}">
@endpush

@push('styles')
<style type="text/css"></style>
@endpush

@section('bodyClass', 'docs language-php')

@push('javascripts')
<script src="{{ asset('vendor/codex/scripts/vendor.js') }}"></script>
<script src="{{ asset('vendor/codex/scripts/codex.js') }}"></script>
<script src="{{ asset('vendor/codex/scripts/theme.js') }}"></script>
@endpush

@section('body')
    <nav class="main">
        <a href="/" class="brand">
            {{--<img src="{{ $assetPath }}/img/laravel-logo.png" height="30" alt="Laravel logo">--}}
            {{ config('codex.display_name') }}
        </a>

        @stack('header')

    </nav>

    <!-- CONTENT -->
    <div class="docs-wrapper">
        @stack('content')
    </div>
    <!-- CONTENT:END -->

    @stack('footer')

@stop

@push('scripts')
<script>
    codex.init();
    codex.theme.init();
</script>
<script>

    jQuery(function () {

        //Check to see if the window is top if not then display button
        jQuery(window).scroll(function () {
            if ( jQuery(this).scrollTop() > 100 ) {
                jQuery('.scrollToTop').fadeIn();
            } else {
                jQuery('.scrollToTop').fadeOut();
            }
        });

        //Click event to scroll to top
        jQuery('.scrollToTop').click(function () {
            jQuery('html, body').animate({scrollTop: 0}, 800);
            return false;
        });
    });
</script>

@endpush