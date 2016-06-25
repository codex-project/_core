<div class="{{ $wrapper_class }} {{ $wrapper_class . '-' . $type }}">
    @if($type === 'groups')

        @foreach($groups as $group => $buttons)
        <div class="{{ $group_wrapper_class }}">
            @foreach($buttons as $button)
                {!! $button->render() !!}
            @endforeach
        </div>
        @endforeach

    @elseif($type === 'buttons')

        @foreach($buttons as $button)
            {!! $button->render() !!}
        @endforeach

    @endif
</div>
