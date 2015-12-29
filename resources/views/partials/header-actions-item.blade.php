
@foreach($item as $displayName => $url)
    @if(is_array($url))
        <div class="dropdown-submenu">
            <a href="#" class="dropdown-item">
                {{ $displayName }}
            </a>
            <div class="dropdown-menu">
                @include('docit::partials/header-actions-item', ['item' => $url])
            </div>
        </div>
    @else
        <a href="{{ $url }}" class="dropdown-item">{{ $displayName }}</a>
    @endif
@endforeach