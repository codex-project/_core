{!! $open !!}

return [
    'display_name' => '{{$displayName}}',

    'filters' => [
        'enabled' => ['attributes', 'markdown', 'replace_header', 'toc']
    ]
];
