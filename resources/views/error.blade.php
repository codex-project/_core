@extends(codex()->view('layouts.base'))

@push('content')
    <div class="text-center">
        <h1>{{ $title }}</h1>
        <p>{{ $text }}</p>
        @if(isset($goBack) && $goBack !== false)
            @set($goBackCount, is_int($goBack) ? $goBack : 1)
            <a href="javascript:history.back({{ $goBackCount }});">Go back</a>
        @endif
    </div>
@endpush