@extends(codex()->view('layout'))


@section('body')

    <!--[if lt IE 10]>
<p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->
<div id="app" class="@yield('appClass', 'page-document')" v-cloak>
    <c-theme :class="classes">
        @section('header')
            <c-header ref="header" :show-toggle="true" :logoLink="{ name: 'welcome' }">
                {{--<div slot="menu">--}}
                @stack('nav')
                {{--</div>--}}
            </c-header>
        @show

        <div class="c-page" ref="page" :style="{ 'min-height': minHeights.page + 'px' }">
            @section('page')
                <c-sidebar ref="sidebar" :min-height="minHeights.inner" active="{{ isset($document) ? $document->url() : ''}}">
                @section('sidebar')
                    <!--<c-sidebar-item v-for="item in menu" :item="item"></c-sidebar-item>-->
                        @if(isset($ref))
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
            <c-footer ref="footer">
                <p>footer</p>
            </c-footer>
        @show
    </c-theme>
</div>

@stop
