@extends(codex()->view('document'))
@section('appClass', 'page-error')

@if(isset($noSidebar) && $noSidebar === true)
    @section('sidebar', '')
@endif

@section('content')
    <h1>{{ isset($title ) ? $title  : 'Error' }}</h1>
    @if(isset($text))
        <p>{{ $text }}</p>
    @endif
    @if(isset($goBack) && $goBack !== false)
        @set($goBackCount, is_int($goBack) ? $goBack : 1)
        <a href="javascript:history.back({{ $goBackCount }});">Go back</a>
    @endif

    @if(isset($trace) && config('app.debug', false) )
        <div class="trace">
            {!! $trace !!}
        </div>
    @endif
@stop