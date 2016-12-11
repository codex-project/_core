@extends(codex()->view('layout'))


@section('body')

    <!--[if lt IE 10]>
<p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->
<div id="app" class="page-document" v-cloak>
    <c-theme :class="classes">
        <c-header ref="header" :show-toggle="true" :logoLink="{ name: 'welcome' }">
            <div slot="menu">
                @stack('nav')
            </div>
        </c-header>

        <div class="c-page" ref="page" :style="{ 'min-height': minHeights.page + 'px' }">
            <c-sidebar ref="sidebar" :min-height="minHeights.inner" active="{{ $document->url() }}">
                <!--<c-sidebar-item v-for="item in menu" :item="item"></c-sidebar-item>-->
                {!! $ref->getSidebarMenu()->render($document->getProject(), $document->getRef()) !!}
            </c-sidebar>

            <c-content ref="content" :min-height="minHeights.inner" autoloader-languages-path="{{ asset('vendor/codex') }}/vendor/prismjs/components/">
                <ol slot="breadcrumb" class="breadcrumb">
                    @include('codex::partials.breadcrumb', ['breadcrumb' => $breadcrumb])
                </ol>
                {!! $document->render()  !!}
            </c-content>
        </div>

        <c-scroll-to-top></c-scroll-to-top>

        <c-footer ref="footer">
            <p>footer</p>
        </c-footer>
    </c-theme>
</div>

@stop
