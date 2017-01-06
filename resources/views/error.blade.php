@extends(codex()->view('document'))

@section('appClass', 'page-error sidebar-closed sidebar-hidden')

@if(isset($noSidebar) && $noSidebar === true)
    @section('sidebar', '')
@endif

@section('content')
    <h1 class="text-xs-center">{{ isset($title ) ? $title  : 'Error' }}</h1>
    @if(isset($text))
        <p class="text-xs-center">{{ $text }}</p>
    @endif
    @if(isset($goBack) && $goBack !== false)
        @set($goBackCount, is_int($goBack) ? $goBack : 1)
        <p class="text-xs-center">
            <a href="javascript:history.back({{ $goBackCount }});">Go back</a>
        </p>
    @endif

    @if(isset($trace) && config('app.debug', false) )
        <div class="trace">
            {!! $trace !!}
        </div>
    @endif
@stop