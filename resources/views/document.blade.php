@extends($document->attr('layout'))

@push('stylesheets')
<link href="{{ asset('vendor/docit/bower_components/highlightjs/styles/tomorrow.css') }}" type="text/css" rel="stylesheet">
@stop

@section('title')
    {{ $document->attr('title') }}
    -
    {{ $project->config('display_name') }}
    ::
    @parent
@stop

@section('pageTitle', $document->attr('title'))
@section('pageSubtitle', $document->attr('subtitle', null))
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

@section('header-actions')
    @parent
    @include('docit::partials/header-actions')
@stop

@section('content')
    {!! $content !!}
@stop

@push('init-scripts')
<script src="{{ asset('vendor/docit/bower_components/highlightjs/highlight.pack.js') }}"></script>
<script>
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
            if(matches[1].length > 0 && hljs.listLanguages().indexOf(matches[1].toLowerCase()) !== -1){
                highlighted = hljs.highlight(matches[1].toLowerCase(), $el.text());
            } else {
                highlighted = hljs.highlightAuto($el.text());
            }
            //console.log('highlighting', highlighted);
            $el.html(highlighted.value);
        })
    })
</script>
@stop
