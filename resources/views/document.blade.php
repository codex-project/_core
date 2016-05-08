@extends($document->attr('views.layout'))

@section('title')
    {{ $document->attr('title') }}
    -
    {{ $project->config('display_name') }}
    ::
    @parent
@stop

@section('page-title', $document->attr('title'))
@section('page-subtitle', $document->attr('subtitle', null))
@section('content')
    {!! $content !!}
@stop