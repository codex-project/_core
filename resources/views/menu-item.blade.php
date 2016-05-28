{{--!! Symfony\Component\VarDumper\VarDumper::dump(['k' => $k, 'item' => $item]) !!}--}}

@if(is_string($k))
    <li><strong>{{ ucfirst($k) }}</strong>
        <ul>
            @foreach($item as $kk => $sitem)
                @include('menu-item', ['k' => $kk, 'item' => $sitem])
            @endforeach
        </ul>
    </li>
@else
    <li><a href="{{ $item['path'] }}">{{ $item['name'] }}</a></li>
@endif
