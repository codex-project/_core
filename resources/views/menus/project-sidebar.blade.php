
@foreach($items as $item)
    <li>
        <a {!!  $item->parseAttributes()  !!}>
            @if($item->hasMeta('icon'))
                <i class="{{ $item->meta('icon') }}"></i>
            @endif
            <span class="title">{{ $item->getValue() }}</span>
            @if($item->hasChildren())
                <span class="arrow"></span>
            @endif
        </a>
        @if($item->hasChildren())
            <ul class="sub-menu">
                @include($menu->getView(), [
                    'items' => $item->getChildren(),
                    'menu' => $menu
                ])
            </ul>
        @endif
    </li>
@endforeach
