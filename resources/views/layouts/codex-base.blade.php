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
{!! codex()->theme->renderStylesheets() !!}
<link rel="apple-touch-icon" href="{{ asset('vendor/codex/favicon.png') }}">
@endpush

@push('styles')
    {!! codex()->theme->renderStyles(); !!}
@endpush

@section('bodyClass', 'docs language-php')

@push('javascripts')
    {!! codex()->theme->renderJavascripts() !!}
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
{!! codex()->theme->renderScripts() !!}
@endpush