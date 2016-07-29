@extends(codex()->view('layouts.default'))

@section('title')
    {{ $document->attr('title') }}
    -
    {{ $project->config('display_name') }}
    ::
    @parent
@stop

@push('nav')
@include('codex::partials.versions')
@endpush

@section('menu-sidebar')
    {!! $ref->renderSidebarMenu() !!}
@stop

@section('content')
    {!! $content !!}
@stop
