{{--@if(isset($item['children']))

    <li class="dropdown">
        <a href="{{ isset($item['href']) ? $item['href'] : '#' }}" class="dropdown-toggle" data-toggle="dropdown">
            @if(isset($item['icon']))
                <i class="{{ $item['icon'] }}"></i>
            @endif
            {{ $item['name'] }}
            <span class="caret"></span>
        </a>
        <ul class="dropdown-menu">

            @each('partials/menu-item', $item['children'], 'item')

        </ul>
    </li>
@else--}}
    <li>
        <a href="{{ isset($item['href']) ? $item['href'] : '#' }}">
            @if(isset($item['icon']))
                <i class="{{ $item['icon'] }}"></i>
            @endif
            <span class="title">{{ $item['name'] }}</span>
            @if(isset($item['children']))
                <span class="arrow"></span>
            @endif
        </a>
        @if(isset($item['children']))
            <ul class="sub-menu">
            @each('codex::partials/menu-item', $item['children'], 'item')
            </ul>
        @endif
    </li>

