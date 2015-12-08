<!DOCTYPE html><!--[if IE 8]>
<html class="ie8" lang="en"><![endif]-->
<!--[if IE 9]>
<html lang="en" class="ie9"><![endif]-->
<!--[if !IE]><!-->
<html lang="en"><!--<![endif]-->
<head>
    <title>
        @section('title')
            {{ config('docit.display_name') }}
        @show
    </title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <link href="{{ asset('vendor/docit/styles/stylesheet.css') }}" type="text/css" rel="stylesheet">
    <link href="{{ asset('vendor/docit/styles/themes/theme-docit.css') }}" type="text/css" rel="stylesheet" id="theme-style">

    @stack('stylesheets')

</head>

@section('body-element')
    <body class="page-loading page-header-fixed page-footer-fixed page-edged page-sidebar-condensed">
    @show

    @section('page-loader')
        <div id="page-loader">
            <div class="loader loader-page"></div>
        </div>
    @show

    <div class="page-header navbar navbar-fixed-top">
        <div class="page-header-inner">
            <div class="page-logo">
                <div class="logo-packadic pull-left">{{ config('docit.display_name') }}</div>
                <div data-toggle="tooltip" title="Toggle the sidebar menu" data-layout-api="sidebar-toggle" data-placement="right" class="menu-toggler sidebar-toggler"></div>
            </div><a href="javascript:;" data-toggle="collapse" data-target=".navbar-collapse" class="menu-toggler responsive-toggler"></a>

            <div class="page-actions">
                @section('header-actions')
                @show
            </div>

            <div class="pull-right">
                <div data-layout-api="qs-toggle" data-toggle="tooltip" title="Toggle the quick sidebar menu" data-placement="left" data-offset="0 10px" class="nav-link quick-sidebar-toggler"></div>
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
        <div class="page-footer-inner">Copyright {{ date('Y') }} &copy; {{ config('docit.display_name') }}</div>
        <div class="scroll-to-top"></div>
    </div>

    @section('quick-sidebar')
        <nav v-el="quick-sidebar" id="quick-sidebar" class="quick-sidebar">
            <div class="qs-header">
                <div class="pull-left">
                    <button type="button" data-layout-api="qs-prev" title="Previous tab" class="btn blue-grey qs-prev"><i class="fa fa-arrow-left"></i></button>
                    <button type="button" data-layout-api="qs-next" title="Next tab" class="btn blue-grey qs-next"><i class="fa fa-arrow-right"></i></button>
                </div>
                <div class="pull-left middle hidden-xs-down hidden-md-up"></div>
                <div class="pull-right">
                    <button type="button" data-layout-api="qs-togglepin" title="Pin/unpin the quick sidebar" class="btn blue-grey-dark hidden-md-down qs-pin"><i class="fa fa-thumb-tack"></i></button>
                    <button type="button" data-layout-api="qs-close" title="Close" class="btn blue-grey qs-close"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="qs-tabs-wrapper">
                <div class="qs-tabs"></div>
            </div>
            <div class="qs-seperator"></div>
            <div id="qs-layout" data-name="Layout" class="qs-content">
                <div class="qs-section">
                    <h3>Layout API</h3>
                    <p>The layout API provides easy interaction with the layout with either HTML5 data-attributes or pure Javascript.</p>
                    <div class="row">
                        <div class="col-xs-6 pr-n text-center">
                            <h4>Core</h4><a class="btn btn-xs blue-grey-light btn-block btn-default" data-layout-api="page-boxed" href="#" role="button">page-boxed</a><a class="btn btn-xs blue-grey btn-block btn-default" data-layout-api="page-edged" href="#" role="button">page-edged</a><a class="btn btn-xs blue-grey-light btn-block btn-default" data-layout-api="header-fixed" href="#" role="button">header-fixed</a><a class="btn btn-xs blue-grey btn-block btn-default" data-layout-api="footer-fixed" href="#" role="button">footer-fixed</a><a class="btn btn-xs blue-grey-light btn-block btn-default" data-layout-api="sidebar-toggle" href="#" role="button">sidebar-toggle</a><a class="btn btn-xs blue-grey btn-block btn-default" data-layout-api="sidebar-fixed" href="#" role="button">sidebar-fixed</a><a class="btn btn-xs blue-grey-light btn-block btn-default" data-layout-api="sidebar-close-submenus" href="#" role="button">sidebar-close-submenus</a><a class="btn btn-xs blue-grey btn-block btn-default" data-layout-api="sidebar-close" href="#" role="button">sidebar-close</a><a class="btn btn-xs blue-grey-light btn-block btn-default" data-layout-api="sidebar-open" href="#" role="button">sidebar-open</a><a class="btn btn-xs blue-grey btn-block btn-default" data-layout-api="sidebar-hide" href="#" role="button">sidebar-hide</a><a class="btn btn-xs blue-grey-light btn-block btn-default" data-layout-api="sidebar-show" href="#" role="button">sidebar-show</a><a class="btn btn-xs blue-grey btn-block btn-default" data-layout-api="sidebar-condensed" href="#" role="button">sidebar-condensed</a><a class="btn btn-xs blue-grey-light btn-block btn-default" data-layout-api="sidebar-hover" href="#" role="button">sidebar-hover</a><a class="btn btn-xs blue-grey btn-block btn-default" data-layout-api="sidebar-reversed" href="#" role="button">sidebar-reversed</a>
                        </div>
                        <div class="col-xs-6 pl-n text-center">
                            <h4>Quick Sidebar</h4><a class="btn btn-xs blue-grey-light btn-block btn-default" data-layout-api="qs-toggle" href="#" role="button">qs-toggle</a><a class="btn btn-xs blue-grey btn-block btn-default" data-layout-api="qs-show" href="#" role="button">qs-show</a><a class="btn btn-xs blue-grey-light btn-block btn-default" data-layout-api="qs-hide" href="#" role="button">qs-hide</a><a class="btn btn-xs blue-grey btn-block btn-default" data-layout-api="qs-open" href="#" role="button">qs-open</a><a class="btn btn-xs blue-grey-light btn-block btn-default" data-layout-api="qs-next" href="#" role="button">qs-next</a><a class="btn btn-xs blue-grey btn-block btn-default" data-layout-api="qs-prev" href="#" role="button">qs-prev</a><a class="btn btn-xs blue-grey-light btn-block btn-default" data-layout-api="qs-pin" href="#" role="button">qs-pin</a><a class="btn btn-xs blue-grey btn-block btn-default" data-layout-api="qs-unpin" href="#" role="button">qs-unpin</a><a class="btn btn-xs blue-grey-light btn-block btn-default" data-layout-api="qs-togglepin" href="#" role="button">qs-togglepin</a>
                            <h4>Styles</h4><a class="btn btn-xs blue-grey-light btn-block btn-default" data-layout-api="theme" data-layout-api-args="default" href="#" role="button">default</a><a class="btn btn-xs blue-grey-light btn-block btn-default" data-layout-api="theme" data-layout-api-args="dark-sidebar" href="#" role="button">dark-sidebar</a>
                            <h4>Presets</h4><a class="btn btn-xs blue-grey btn-block btn-default" data-layout-api="preset" data-layout-api-args="default" href="#" role="button">Default</a><a class="btn btn-xs blue-grey btn-block btn-default" data-layout-api="preset" data-layout-api-args="condensed-dark" href="#" role="button">Condensed Dark</a>
                        </div>
                    </div>
                </div>
            </div>
            <div id="qs-random" data-name="Random" class="qs-content">
                <div class="qs-section">
                    <h3>Random</h3>
                    <p>asdf 0</p>
                    <p>asdf 1</p>
                    <p>asdf 2</p>
                    <p>asdf 3</p>
                    <p>asdf 4</p>
                    <p>asdf 5</p>
                    <p>asdf 6</p>
                    <p>asdf 7</p>
                    <p>asdf 8</p>
                    <p>asdf 9</p>
                    <p>asdf 10</p>
                    <p>asdf 11</p>
                    <p>asdf 12</p>
                    <p>asdf 13</p>
                    <p>asdf 14</p>
                    <p>asdf 15</p>
                    <p>asdf 16</p>
                    <p>asdf 17</p>
                    <p>asdf 18</p>
                    <p>asdf 19</p>
                    <p>asdf 20</p>
                    <p>asdf 21</p>
                    <p>asdf 22</p>
                    <p>asdf 23</p>
                    <p>asdf 24</p>
                    <p>asdf 25</p>
                    <p>asdf 26</p>
                    <p>asdf 27</p>
                    <p>asdf 28</p>
                    <p>asdf 29</p>
                </div>
            </div>
            <div id="qs-extras" data-name="Extras" class="qs-content">
                <div class="qs-section">
                    <h3>Extras</h3>
                    <p>Line 0</p>
                    <p>Line 1</p>
                    <p>Line 2</p>
                    <p>Line 3</p>
                    <p>Line 4</p>
                    <p>Line 5</p>
                    <p>Line 6</p>
                    <p>Line 7</p>
                    <p>Line 8</p>
                    <p>Line 9</p>
                    <p>Line 10</p>
                    <p>Line 11</p>
                    <p>Line 12</p>
                    <p>Line 13</p>
                    <p>Line 14</p>
                    <p>Line 15</p>
                    <p>Line 16</p>
                    <p>Line 17</p>
                    <p>Line 18</p>
                    <p>Line 19</p>
                    <p>Line 20</p>
                    <p>Line 21</p>
                    <p>Line 22</p>
                    <p>Line 23</p>
                    <p>Line 24</p>
                    <p>Line 25</p>
                    <p>Line 26</p>
                    <p>Line 27</p>
                    <p>Line 28</p>
                    <p>Line 29</p>
                </div>
            </div>
            <div id="qs-another" data-name="Another" class="qs-content">
                <div class="qs-section">
                    <h3>Another</h3>
                    <p>Anotherf 0</p>
                    <p>Anotherf 1</p>
                    <p>Anotherf 2</p>
                    <p>Anotherf 3</p>
                    <p>Anotherf 4</p>
                    <p>Anotherf 5</p>
                    <p>Anotherf 6</p>
                    <p>Anotherf 7</p>
                    <p>Anotherf 8</p>
                    <p>Anotherf 9</p>
                    <p>Anotherf 10</p>
                    <p>Anotherf 11</p>
                    <p>Anotherf 12</p>
                    <p>Anotherf 13</p>
                    <p>Anotherf 14</p>
                    <p>Anotherf 15</p>
                    <p>Anotherf 16</p>
                    <p>Anotherf 17</p>
                    <p>Anotherf 18</p>
                    <p>Anotherf 19</p>
                    <p>Anotherf 20</p>
                    <p>Anotherf 21</p>
                    <p>Anotherf 22</p>
                    <p>Anotherf 23</p>
                    <p>Anotherf 24</p>
                    <p>Anotherf 25</p>
                    <p>Anotherf 26</p>
                    <p>Anotherf 27</p>
                    <p>Anotherf 28</p>
                    <p>Anotherf 29</p>
                </div>
            </div>
            <div id="qs-makeifythis" data-name="Makeifythis" class="qs-content">
                <div class="qs-section">
                    <h3>Other</h3>
                    <p>Line 0</p>
                    <p>Line 1</p>
                    <p>Line 2</p>
                    <p>Line 3</p>
                    <p>Line 4</p>
                    <p>Line 5</p>
                    <p>Line 6</p>
                    <p>Line 7</p>
                    <p>Line 8</p>
                    <p>Line 9</p>
                    <p>Line 10</p>
                    <p>Line 11</p>
                    <p>Line 12</p>
                    <p>Line 13</p>
                    <p>Line 14</p>
                    <p>Line 15</p>
                    <p>Line 16</p>
                    <p>Line 17</p>
                    <p>Line 18</p>
                    <p>Line 19</p>
                    <p>Line 20</p>
                    <p>Line 21</p>
                    <p>Line 22</p>
                    <p>Line 23</p>
                    <p>Line 24</p>
                    <p>Line 25</p>
                    <p>Line 26</p>
                    <p>Line 27</p>
                    <p>Line 28</p>
                    <p>Line 29</p>
                </div>
            </div>
            <div id="qs-nevertheless" data-name="Nevertheless" class="qs-content">
                <div class="qs-section">
                    <h3>Other</h3>
                    <p>Line 0</p>
                    <p>Line 1</p>
                    <p>Line 2</p>
                    <p>Line 3</p>
                    <p>Line 4</p>
                    <p>Line 5</p>
                    <p>Line 6</p>
                    <p>Line 7</p>
                    <p>Line 8</p>
                    <p>Line 9</p>
                    <p>Line 10</p>
                    <p>Line 11</p>
                    <p>Line 12</p>
                    <p>Line 13</p>
                    <p>Line 14</p>
                    <p>Line 15</p>
                    <p>Line 16</p>
                    <p>Line 17</p>
                    <p>Line 18</p>
                    <p>Line 19</p>
                    <p>Line 20</p>
                    <p>Line 21</p>
                    <p>Line 22</p>
                    <p>Line 23</p>
                    <p>Line 24</p>
                    <p>Line 25</p>
                    <p>Line 26</p>
                    <p>Line 27</p>
                    <p>Line 28</p>
                    <p>Line 29</p>
                </div>
            </div>
        </nav>
    @show

    <script src="{{ asset('vendor/docit/bower_components/reflect-metadata/Reflect.js') }}"></script>
    <script src="{{ asset('vendor/docit/bower_components/es6-module-loader/dist/es6-module-loader.js') }}"></script>
    <script src="{{ asset('vendor/docit/bower_components/system.js/dist/system.js') }}"></script>
    <script src="{{ asset('vendor/docit/bower_components/vue/dist/vue.js') }}"></script>
    <script src="{{ asset('vendor/docit/scripts/vendor.js') }}"></script>
    <script src="{{ asset('vendor/docit/scripts/noty.js') }}"></script>

    <script src="{{ asset('vendor/docit/scripts/templates.min.js') }}"></script>

    <script src="{{ asset('vendor/docit/scripts/packadic.js') }}"></script>
    <script src="{{ asset('vendor/docit/scripts/addons.js') }}"></script>
    <script src="{{ asset('vendor/docit/scripts/docit.js') }}"></script>

    @stack('config-scripts')

    @section('init-script')
        <script>
            (function() {
                var app = packadic.Application.instance;
                if ( ! app.isInitialised ) {
                    app.init({
                        assetPath: '/vendor/docit'
                    });
                }
                $(function(){
                    return;
                    $('pre > code.prettyprint').each(function(){
                        var $code = $(this);
                        var $pre  = $code.parent();
                        var code = $code.get(0).innerHTML;
                        var lang ;
                        $code.get(0).classList.forEach(function(className){
                            if(packadic.util.str.startsWith(className, 'lang-')){
                                lang = className.replace('lang-', '');
                            }
                        });
                        if(typeof lang !== 'undefined') {
                            var $codeBlock = $('<code-block>').attr('language', lang);
                            $pre.replaceWith($codeBlock);
                        }

                    })
                })
                app.boot().then(function (app) {
                    app.debug.log('BOOTED FROM boot-script');
                });
            }.call())

        </script>
    @show

    @stack('init-scripts')

    </body>
</html>
