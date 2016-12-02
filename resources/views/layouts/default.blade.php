@extends('codex::base')
@section('body')

@section('header')
    <header>
        @stack('header')
        <h1>{{ config('codex.display_name') }}</h1>
        @stack('nav')
    </header>
@show

@stack('wrapin')

<a class="sidebar-toggle" data-action='sidebar-toggle' title='Toggle sidebar'><i class="fa fa-list"></i></a>

@section('sidebar-menu')
    <aside>
        {!! codex()->menus->render('sidebar', $project, $ref) !!}
    </aside>
@show


@section('breadcrumb')
    <nav>
        <ul data-layout="breadcrumbs">
            <li><a href="{{ route('codex.index') }}">Home</a><i class="fa fa-arrow-right"></i></li>
        </ul>
    </nav>
@show


@section('errors')
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{!! $error  !!} </li>
                @endforeach
            </ul>
        </div>
    @endif
@show

@section('article')
    <article class="content @yield('articleClass', '')" data-layout="article">
        @yield('content', '')
    </article>
@show

@stack('outro')

@stack('wrapout')

@section('footer')
    <footer>

    </footer>
@show

@stop
