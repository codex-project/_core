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

@section('content')
    <div class="top-buttons top-buttons-groups">
        <div class="top-button-group">
            <a text="Github" href="https://github.com/codex-project/codex" target="_blank" class=" btn btn-primary">Github</a>
            <a text="Packagist" href="https://github.com/codex-project/codex" target="_blank" class=" btn btn-primary">Packagist</a>
        </div>
    </div>
    {!! $content !!}
@stop
