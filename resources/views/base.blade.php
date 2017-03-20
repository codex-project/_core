@section('opener')
<!DOCTYPE html><!--[if IE 8]>
<html class="ie8" lang="en"><![endif]-->
<!--[if IE 9]>
<html lang="en" class="ie9"><![endif]-->
<!--[if !IE]><!-->
<html lang="en"><!--<![endif]-->
@show
<head>

    @stack('head-pre')

    @stack('meta')


    <title>
        @section('title')
            @stack('title')
        @show
    </title>

    @foreach([] as $b)
        {{ $loop->index}}
    @endforeach

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

    @stack('head-after')

</head>

@section('body-tag')
<body class="@yield('body-tag-styles', '')">
@show

@section('body')
@show

@section('javascripts')
    {!! codex()->theme->renderJavascripts() !!}
@show

@section('scripts')
    {!! codex()->theme->renderScripts() !!}
@show


</body>
</html>
