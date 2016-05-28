@foreach($items as $item)
    @if($item->hasChildren())
        <div class="dropdown-submenu">
            <a href="#" class="dropdown-item">
                {{ $item->getValue() }}
            </a>
            <div class="dropdown-menu">
                @include($menu->getView(), [
                    'items' => $item->getChildren(),
                    'menu' => $menu
                ])
            </div>
        </div>
    @else

        <a href="{{ $item->attribute('href', '#') }}" class="dropdown-item">
            @if($item->meta('icon', false) !== false)
                <i class="{{ $item->meta('icon') }}"></i>
            @endif
            {{ $item->getValue() }}
        </a>
    @endif
@endforeach
