<?php /** @var \Codex\Core\Menus\Menu[] $items */ ?>
@foreach($items as $item)
    <li class="{{ $item->hasChildren() ? 'with-sub-menu' : '' }}">
        @if($item->hasChildren())
            @if($item->hasMeta('icon'))
                <i class="{{ $item->meta('icon') }}"></i>
            @endif
            <span class="sub-menu-title">{{ $item->getValue() }}</span>

            <ul class="sub-menu">
                @include('codex::menus.sidebar-child', [
                    'items' => $item->getChildren(),
                    'menu' => $menu
                ])
            </ul>
        @else
            @if($item->hasMeta('icon'))
                {{--<i class="{{ $item->meta('icon') }}"></i>--}}
            @endif
            <a {!!  $item->parseAttributes()  !!}>
                {{ $item->getValue() }}
            </a>
        @endif
    </li>
@endforeach
