@extends('codex::layouts.base')

@push('styles')
    <style type="text/css">

    </style>
@endpush

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
                    @stack('header-actions')
                </div>

                <div class="page-top">
                    <div class="top-menu">
                        <ul class="nav navbar-nav pull-right">
                            @stack('header-top-menu')
                        </ul>
                    </div>
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

                @section('page-errors')
                    @if (count($errors) > 0)
                    <div class="page-alerts page-alerts-top">
                        @include('codex::partials/errors')
                    </div>
                    @endif
                @show

                @section('page-head')
                <div class="page-head">
                    <div class="page-title">
                        <h1>@yield('page-title')<small> @yield('page-subtitle', '')</small></h1>
                    </div>
                </div>
                @show

                @section('page-breadcrumb')
                <ul class="page-breadcrumb breadcrumb">
                    @section('breadcrumb')
                        <li><a href="{{ route('codex.index') }}">Home</a><i class="fa fa-arrow-right"></i></li>
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
