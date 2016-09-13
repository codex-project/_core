@section('opener')
<!DOCTYPE html><!--[if IE 8]>
<html class="ie8" lang="en"><![endif]-->
<!--[if IE 9]>
<html lang="en" class="ie9"><![endif]-->
<!--[if !IE]><!-->
<html lang="en"><!--<![endif]-->
@show
<head>
    <title>
        @section('title')
            {{ config('codex.display_name') }}
        @show
    </title>

    @stack('meta')

    @section('data')
        {!! codex()->theme->renderData() !!}
    @show

    @section('stylesheets')
        {!! codex()->theme->renderStylesheets() !!}
    @show

    @section('styles')
        {!! codex()->theme->renderStyles(); !!}
    @show

    @stack('head')

</head>

<body class="{{ codex()->theme->renderBodyClass() }}">

{{--
Instead of overiding/appending all "sub-sections", one could also create their own "sub-sections" by using
 a custom body section.
--}}
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

@show

@section('javascripts')
    {!! codex()->theme->renderJavascripts() !!}
@show

@section('scripts')
    {!! codex()->theme->renderScripts() !!}
@show


</body>
</html>
