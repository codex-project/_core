@extends(codex()->view('layout'))

@if(isset($document))
    @push('title')
    | {{ $document->getProject()->getDisplayName() }}
    {{ '@' }} {{ $document->getRef()->getName() }}
    | {{ $document->attr('title', $document->getPathName()) }}
    @endpush
@endif

@section('scripts')
    @parent
    <script>
        Vue.use(CodexPlugin)
        Vue.use(CodexPhpdocPlugin)
        var app = new codex.App({
            el    : '#app',
            mixins: [Vue.codex.phpdoc.mixins.phpdocDocument]
        })
    </script>
@stop

@section('body')
    <div id="page-loader">
        <div class="loader loader-page"></div>
    </div>
    <!--[if lt IE 10]>
    <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->
    <div id="app" class="@yield('appClass', 'page-document' . (isset($ref) && $ref->hasSidebarMenu() === false ? ' sidebar-hidden':''))" v-cloak>
        <c-theme :class="classes">
            @section('header')
                <c-header ref="header" :show-toggle="true" :logoLink="{ name: 'welcome' }">
                    @stack('nav')
                </c-header>
            @show

            <div class="c-page" ref="page" :style="{ 'min-height': minHeights.page + 'px' }">
                @section('page')
                    <c-sidebar ref="sidebar" class="sidebar-compact" :min-height="minHeights.inner" active="{{ isset($document) ? $document->url() : ''}}">
                        @section('sidebar')
                            @if(isset($ref) && $ref->hasSidebarMenu())
                                {!! $ref->getSidebarMenu()->render($project, $ref) !!}
                            @endif
                        @show
                    </c-sidebar>

                    <c-content ref="content" :min-height="minHeights.inner" autoloader-languages-path="{{ asset('vendor/codex') }}/vendor/prismjs/components/">
                        @section('content')
                            @if(isset($breadcrumb))
                                <ol slot="breadcrumb" class="breadcrumb">
                                    @include('codex::partials.breadcrumb', ['breadcrumb' => $breadcrumb])
                                </ol>
                            @endif
                            @if(isset($document))
                                {!! $document->render()  !!}
                            @endif
                        @show
                    </c-content>
                @show
            </div>

            <c-scroll-to-top></c-scroll-to-top>

            @section('footer')
                @include('codex::partials.footer');
            @show
        </c-theme>
    </div>

@stop
