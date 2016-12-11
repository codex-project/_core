<?php /** @var \Codex\Menus\Menu[] $items */ ?>
@foreach($items as $item)
    <c-sidebar-item
        {!!  $item->parseAttributes()  !!}
        title="{{ $item->getValue() }}"
        :has-children="{{ $item->hasChildren() === true ? 'true' : 'false'}}"
        @if($item->attribute('href', '#') !== '#')
            href="{{ $item->attribute('href') }}"
        @endif
    @if($item->hasMeta('icon'))
        icon="{{ $item->meta('icon') }}"
    @endif
    >
        @if($item->hasChildren())
            @include('codex::menus.sidebar-child', [
                'items' => $item->getChildren(),
                'menu' => $menu
            ])
        @endif
    </c-sidebar-item>
@endforeach
