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

    @stack('styles')

</head>

<body class="@yield('bodyClass', 'page-loading page-header-fixed page-footer-fixed page-edged page-sidebar-condensed page-sidebar-fixed')">

    @section('page-loader')
        <div id="page-loader">
            <div class="loader loader-page"></div>
        </div>
    @show

    @yield('body')


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
