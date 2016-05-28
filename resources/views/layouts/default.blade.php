@extends('codex::layouts.codex-base')

@push('header')
    <div class="responsive-sidebar-nav">
        <a href="#" class="toggle-slide menu-link btn">&#9776;</a>
    </div>
    @section('menu-versions')
        @include('codex::partials.header.versions')
    @show

    @section('menu-projects')
        {!! $codex->menus->get('projects')->render() !!}
    @show
@endpush


@push('content')

    @section('menu-sidebar')
        {!! $codex->menus->get('sidebar')->render() !!}
    @show

    @section('breadcrumb')
        @parent
        @include('codex::partials.breadcrumb')
    @show

    <article class="@yield('articleClass', '')">
        @yield('content')
    </article>
@endpush

@push('footer')
    @section('scroll-to-top')
    <a href="#" class="scrollToTop"></a>
    @show
    @section('footer')
    <footer class="main">
        <p>Copyright &copy; {{ config('codex.display_name') }}.</p>
    </footer>
    @show
@endpush
