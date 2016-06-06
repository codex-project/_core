@extends(codex()->view('layouts.base'))

@push('content')
    <div class="text-center">
        <h1>{{ $title }}</h1>
        <p>{{ $text }}</p>
        @if(isset($goBack) && $goBack === true)
        <a href="javascript:history.back(1);">Go back</a>
        @endif
    </div>
@endpush