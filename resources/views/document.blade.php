@extends('codex::layouts.default')

@section('title')
    {{ $document->attr('title') }}
    -
    {{ $project->config('display_name') }}
    ::
    @parent
@stop


@section('content')

    <header>
        <small>{{ $document->attr('subtitle', '') }}</small>
        <h1>{{ $document->attr('title') }}
        </h1>
    </header>
    {!! $content !!}
@stop
