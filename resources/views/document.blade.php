@extends(codex()->view('layouts.default'))

{{-- Title --}}
@section('title')
    {{ $document->attr('title') }}
    -
    {{ $project->config('display_name') }}
    ::
    @parent
@endsection

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
@endsection

{{-- Header --}}
@section('header')
    <nav class="main" data-layout="nav">
        @stack('header')
        <a href="/" class="brand">
            {{ config('codex.display_name') }}
        </a>
        @stack('nav')
    </nav>
@endsection


{{-- Document --}}
@push('wrapin')
<div class="docs-wrapper" data-layout="wrapper">
    @endpush

    @section('sidebar-menu')
        <a class="sidebar-toggle" data-action='sidebar-toggle' title='Toggle sidebar'><i class="fa fa-list"></i></a>
        {!! codex()->menus->render('sidebar', $project, $ref) !!}
    @endsection

    @section('breadcrumb')
        @include('codex::partials.breadcrumb')
    @endsection

    @section('article')
        <article class="content @yield('articleClass', '')" data-layout="article">
            {!! $content !!}
        </article>
    @endsection

    @stack('outro')

    @push('wrapout')
</div>
@endpush


{{-- Footer --}}
@section('footer')
    <a href="#" class="scrollToTop"></a>
    <footer class="main" data-layout="footer">
        <p>Copyright &copy; {{ config('codex.display_name') }}.</p>
    </footer>
@endsection

