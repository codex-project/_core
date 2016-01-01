<!DOCTYPE html><!--[if IE 8]>
<html class="ie8" lang="en"><![endif]-->
<!--[if IE 9]>
<html lang="en" class="ie9"><![endif]-->
<!--[if !IE]><!-->
<html lang="en"><!--<![endif]-->
<head>
    <title>
        @section('title')
            {{ config('codex.display_name') }}
        @show
    </title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <link href="{{ asset('vendor/codex/styles/stylesheet.css') }}" type="text/css" rel="stylesheet">
    <link href="{{ asset('vendor/codex/styles/themes/theme-codex.css') }}" type="text/css" rel="stylesheet" id="theme-style">

    @stack('stylesheets')

</head>

<body class="@yield('bodyClass', 'page-loading page-header-fixed page-footer-fixed page-edged page-sidebar-condensed')">

    @section('page-loader')
        <div id="page-loader">
            <div class="loader loader-page"></div>
        </div>
    @show

    <div class="page-header navbar navbar-fixed-top">
        <div class="page-header-inner">
            <div class="page-logo">
                <div class="logo-packadic pull-left">{{ config('codex.display_name') }}</div>
                <div data-toggle="tooltip" title="Toggle the sidebar menu" data-layout-api="sidebar-toggle" data-placement="right" class="menu-toggler sidebar-toggler"></div>
            </div><a href="javascript:;" data-toggle="collapse" data-target=".navbar-collapse" class="menu-toggler responsive-toggler"></a>

            <div class="page-actions">
                @section('header-actions')
                @show
            </div>


            <div class="pull-right">
                @if(isset($quickSidebar) && $quickSidebar === true)
                    <div data-layout-api="qs-toggle" data-toggle="tooltip" title="Toggle the quick sidebar menu" data-placement="left" data-offset="0 10px" class="nav-link quick-sidebar-toggler"></div>
                @endif
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="page-container">
        <div class="page-sidebar-wrapper">
            <div class="page-sidebar navbar-collapse">
                <ul class="page-sidebar-menu">
                    @section('sidebar-menu')
                    @show
                </ul>
            </div>
        </div>
        <div class="page-content-wrapper">
            <div class="page-content">
                <div class="page-head">
                    <div class="page-title">
                        <h1>@yield('pageTitle')<small> @yield('pageSubtitle', '')</small></h1>
                    </div>
                </div>
                <ul class="page-breadcrumb breadcrumb">
                    @section('breadcrumb')
                        <li><a href="index.html">Home</a><i class="fa fa-arrow-right"></i></li>
                    @show
                </ul>
                <div class="page-content-seperator"></div>
                <div class="page-content-inner">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
    <div class="page-footer">
        <div class="page-footer-inner">Copyright {{ date('Y') }} &copy; {{ config('codex.display_name') }}</div>
        <div class="scroll-to-top"></div>
    </div>


    <script src="{{ asset('vendor/codex/scripts/vendor.js') }}"></script>
    <script src="{{ asset('vendor/codex/scripts/packadic.js') }}"></script>
    <script src="{{ asset('vendor/codex/scripts/addons.js') }}"></script>

    @stack('scripts')

    @section('init-script')
        <script>
            (function() {
                var app = packadic.Application.instance;
                if ( ! app.isInitialised ) {
                    app.init({
                        assetPath: '/vendor/codex'
                    });
                }
            }.call())

        </script>
    @show

    @stack('init-scripts')

    @section('boot-script')
        <script>
            (function() {
                var app = packadic.Application.instance;
                app.boot().then(function (app) {
                    app.debug.log('BOOTED FROM boot-script');
                });
            }.call())
        </script>
    @show

    @stack('boot-scripts')

    </body>
</html>
