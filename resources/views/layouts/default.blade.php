@extends(codex()->view('layouts.base'))

{{-- Meta --}}
@push('meta')
<meta name="description" content="{{ config('codex.display_name') }}.">
<meta name="keywords" content="laravel, php, framework, web, artisans, taylor otwell">
<meta name="viewport" content="width=device-width, initial-scale=1">
@endpush

{{-- Stylesheets --}}
@section('stylesheets')
    @parent
    <link rel="apple-touch-icon" href="{{ asset('vendor/codex/images/apple-touch-icon.png') }}">
    <link rel="icon" href="{{ asset('vendor/codex/images/favicon.png') }}">
@show

{{-- Body --}}
@section('body')
    <nav class="main" data-layout="nav">
        @section('header')
            <a href="/" class="brand">
                {{--<img src="{{ $assetPath }}/img/laravel-logo.png" height="30" alt="Laravel logo">--}}
                {{ config('codex.display_name') }}
            </a>

            @stack('nav')

        @show
    </nav>

    <!-- CONTENT -->
    <div class="docs-wrapper" data-layout="wrapper">

        @section('wrapper')

            @section('article')
                <article class="content @yield('articleClass', '')" data-layout="article">
                    @yield('content', '')
                </article>
            @show

            @stack('content')

        @show
    </div>
    <!-- CONTENT:END -->

    @stack('footer')

@stop

{{-- Footer --}}
@push('footer')
@section('scroll-to-top')
    <a href="#" class="scrollToTop"></a>
@show
@section('footer')
    <footer class="main" data-layout="footer">
        <p>Copyright &copy; {{ config('codex.display_name') }}.</p>
    </footer>
@show
@endpush

