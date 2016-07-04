{!! $open !!}

return [
    'display_name' => '{{$displayName}}',

    'processors' => [
        'enabled'    => [ 'attributes', 'parser', 'toc', 'header', 'macros', 'buttons', 'links' ],
    ]
];
