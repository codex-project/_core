
@foreach($items as $item)
    <li>
        <a {{ $item->parseAttributes() }}>
            @if($item->meta('icon', false) !== false)
                <i class="{{ $item->meta('icon') }}"></i>
            @endif
            <span class="title">{{ $item->getValue() }}</span>
            @if($item->hasChildren())
                <span class="arrow"></span>
            @endif
        </a>
        @if($item->hasChildren())
            <ul class="sub-menu">
                @breakpoint
            @include($menu->getView(), [
                'items' => $item->getChildren(),
                'menu' => $menu
            ])
            </ul>
        @endif
    </li>
@endforeach
