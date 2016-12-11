@if(isset($breadcrumb))
    <li class="breadcrumb-item"><a href="{{ $document->getProject()->url('index') }}">{{ $document->getProject()->getDisplayName() }}</a></li>
    @foreach($breadcrumb as $item)
        @if($item->getId() !== 'root')
            <li class="breadcrumb-item">
                @if($item->meta('type') === 'parent')
                    {{ $item->getValue() }}
                @else
                    <a {!! $item->parseAttributes() !!}>{{ $item->getValue() }}</a>
                @endif
            </li>
        @endif
    @endforeach
@endif
