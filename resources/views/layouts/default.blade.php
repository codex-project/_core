@extends('codex::layouts.base')


@section('body')

    @section('page-header')
    <div class="page-header navbar navbar-fixed-top">
        <div class="page-header-inner">
            <div class="page-logo">
                <div class="logo-packadic pull-left">{{ config('codex.display_name') }}</div>
                @section('page-header-sidebar-toggle')
                <div data-toggle="tooltip" title="Toggle the sidebar menu" data-layout-api="sidebar-toggle" data-placement="right" class="menu-toggler sidebar-toggler"></div>
                @show
            </div><a href="javascript:;" data-toggle="collapse" data-target=".navbar-collapse" class="menu-toggler responsive-toggler"></a>

            @section('page-header-actions')
            <div class="page-actions">
                @section('header-actions')
                @show
            </div>
            @show

            <div class="pull-right">
                @if(isset($quickSidebar) && $quickSidebar === true)
                    <div data-layout-api="qs-toggle" data-toggle="tooltip" title="Toggle the quick sidebar menu" data-placement="left" data-offset="0 10px" class="nav-link quick-sidebar-toggler"></div>
                @endif
            </div>
        </div>
    </div>
    @show

    @yield('page-clearfix', '<div class="clearfix"></div>')

    @section('page-container')
    <div class="page-container">

        @section('page-sidebar-wrapper')
        <div class="page-sidebar-wrapper">
            <div class="page-sidebar navbar-collapse">
                <ul class="page-sidebar-menu">
                    @section('sidebar-menu')
                    @show
                </ul>
            </div>
        </div>
        @show

        @section('page-content-wrapper')
        <div class="page-content-wrapper">
            <div class="page-content">
                @section('page-head')
                <div class="page-head">
                    <div class="page-title">
                        <h1>@yield('pageTitle')<small> @yield('pageSubtitle', '')</small></h1>
                    </div>
                </div>
                @show

                @section('page-breadcrumb')
                <ul class="page-breadcrumb breadcrumb">
                    @section('breadcrumb')
                        <li><a href="index.html">Home</a><i class="fa fa-arrow-right"></i></li>
                    @show
                </ul>
                @show

                <div class="page-content-seperator"></div>
                <div class="page-content-inner">
                    @yield('content')
                </div>
            </div>
        </div>
        @show
    </div>
    @show

    @section('page-footer')
    <div class="page-footer">
        <div class="page-footer-inner">Copyright {{ date('Y') }} &copy; {{ config('codex.display_name') }}</div>
        <div class="scroll-to-top"></div>
    </div>
    @show

@stop
