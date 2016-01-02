@extends('codex::layouts.default')

@push('styles')
<link href="{{ asset('vendor/codex/bower_components/highlightjs/styles/tomorrow.css') }}" type="text/css" rel="stylesheet">
@endpush

@section('breadcrumb')
    @parent
    @if(isset($breadcrumb))
        @foreach($breadcrumb as $item)
            @if($item->getId() !== 'root')
                <li>
                    <a {!! $item->parseAttributes() !!}>{{ $item->getValue() }}</a>
                    @if($item->hasChildren())
                        <i class="fa fa-arrow-right"></i>
                    @endif
                </li>
            @endif
        @endforeach
    @endif
@stop

@section('sidebar-menu')
    {!! $project->getDocumentsMenu()->render() !!}
@stop

@push('header-actions')
    @include('codex::partials/header-actions')
@endpush

@push('init-scripts')
<script src="{{ asset('vendor/codex/bower_components/highlightjs/highlight.pack.js') }}"></script>
<script>
    var hljsLangs = hljs.listLanguages();
    $(function(){
        console.log('highlighting');
        if(typeof window.hljs === 'undefined' || $('code.hljs').length === 0){
            console.log('highlighting failed');
            return;
        }
        $('code.hljs').each(function(){
            console.log('highlighting', this);
            var $el = $(this);
            var matches = this.className.match(/lang\-(.*)(?:\s|)/);
            var highlighted;
            if(matches[1].length > 0 && hljsLangs.indexOf(matches[1].toLowerCase()) !== -1){
                highlighted = hljs.highlight(matches[1].toLowerCase(), $el.text());
            } else {
                highlighted = hljs.highlightAuto($el.text());
            }
            //console.log('highlighting', highlighted);
            $el.html(highlighted.value);
        })
    })
</script>
@endpush
