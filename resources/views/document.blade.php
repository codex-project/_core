@extends(codex()->view('layouts.default'))

@section('title')
    {{ $document->attr('title') }}
    -
    {{ $project->config('display_name') }}
    ::
    @parent
@stop

@section('header')
    @parent

    <div class="responsive-sidebar-nav">
        <a href="#" class="toggle-slide menu-link btn">&#9776;</a>
    </div>

    @include('codex::partials.versions')

    {!! codex()->menus->render('projects') !!}


@stop

@section('wrapper')
    <a class="sidebar-toggle" data-action='sidebar-toggle' title='Toggle sidebar'><i class="fa fa-list"></i></a>
    {!! codex()->menus->render('sidebar', $ref) !!}
    @include('codex::partials.breadcrumb')
    @parent
@stop

@section('content')
    {!! $content !!}
@stop
