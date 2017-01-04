@extends(codex()->view('layout'))

@section('body')
<!--[if lt IE 10]>
<p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->
<div id="app" class="page-welcome" v-cloak>
    <c-theme>
        <c-header ref="header" :show-toggle="false">
            <div slot="menu">
                @include('codex::partials.welcome-nav-items')
            </div>
        </c-header>

        <div class="c-page" ref="page">

            <!--CAROUSEL / SLIDER-->
            <c-section id="welcome" class="scrollspy c-section-dark" :full-width="true">
                <c-carousel
                        :height="carouselHeight"
                        :interval="5500"
                        :controls="true"
                        control-bottom="#open-source"
                        :indicators="false"
                        class="scrollspy">
                    <c-carousel-item img="{{ asset('vendor/codex') }}/img/screen-typewriter.jpg">
                        <div class="carousel-caption"><p>Completely customizable and dead simple to use to create beautiful documentation.</p></div>
                    </c-carousel-item>
                    <c-carousel-item img="{{ asset('vendor/codex') }}/img/screen-html.png">
                        <div class="carousel-caption"><p>Seamless integration of PHPDoc, Github/Bitbucket and more!</p></div>
                    </c-carousel-item>
                    <!--<carousel-item img="/img/bg-52.jpg"> <span class="carousel-item-text">Codex will be</span> </carousel-item>-->
                    <!--<carousel-item img="/img/bg-53.jpg"></carousel-item>-->
                </c-carousel>
            </c-section>

            <!-- OPEN SOURCE -->
            <c-section id="open-source"  class="scrollspy wow fadeIn c-section-dark" data-wow-duration="2s">
                <div class="awesome">
                    <div class="awesome-title"> Open Source</div>
                    <div class="awesome-text">Codex is available on<a href="#"> GitHub</a> under the<a href="#"> MIT license</a></div>
                    <div class="awesome-divider"></div>
                </div>
            </c-section>

            <!--FEATURES-->
            <c-section id="features" class="scrollspy c-section-light">
                <header>
                    <h2>Features</h2>
                    <hr>
                </header>

                <div class="row">
                    <div class="col-lg-4 wow slideInUp fadeIn" data-wow-duration="2s">
                        <img class="img-circle" src="{{ asset('vendor/codex') }}/img/fa-puzzle-piece-140x140-37474f.png" alt="Generic placeholder image" width="140" height="140" style="margin-left: 25px">
                        <h3>Plugins</h3>
                        <p class="lead">Using a plugin based approach, Codex can easily be extended. Check out <a href="#">existing plugins</a> or <a href="#">create something custom</a>.</p>
                    </div><!-- /.col-lg-4 -->
                    <div class="col-lg-4 wow slideInUp fadeIn" data-wow-delay="0.35s" data-wow-duration="2s">
                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg"
                             xmlns:xlink="http://www.w3.org/1999/xlink"
                             xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0"
                             x="0px" y="0px" width="140px" height="140px" viewBox="0 0 84.1 57.6" enable-background="new 0 0 84.1 57.6"
                             xml:space="preserve">
                            <defs>
                            </defs>
                            <path fill="#FB503B" d="M83.8,26.9c-0.6-0.6-8.3-10.3-9.6-11.9c-1.4-1.6-2-1.3-2.9-1.2s-10.6,1.8-11.7,1.9c-1.1,0.2-1.8,0.6-1.1,1.6
                                c0.6,0.9,7,9.9,8.4,12l-25.5,6.1L21.2,1.5c-0.8-1.2-1-1.6-2.8-1.5C16.6,0.1,2.5,1.3,1.5,1.3c-1,0.1-2.1,0.5-1.1,2.9
                                c1,2.4,17,36.8,17.4,37.8c0.4,1,1.6,2.6,4.3,2c2.8-0.7,12.4-3.2,17.7-4.6c2.8,5,8.4,15.2,9.5,16.7c1.4,2,2.4,1.6,4.5,1
                                c1.7-0.5,26.2-9.3,27.3-9.8c1.1-0.5,1.8-0.8,1-1.9c-0.6-0.8-7-9.5-10.4-14c2.3-0.6,10.6-2.8,11.5-3.1C84.2,28,84.4,27.5,83.8,26.9z
                                 M37.5,36.4c-0.3,0.1-14.6,3.5-15.3,3.7c-0.8,0.2-0.8,0.1-0.8-0.2C21.2,39.6,4.4,4.8,4.1,4.4c-0.2-0.4-0.2-0.8,0-0.8
                                c0.2,0,13.5-1.2,13.9-1.2c0.5,0,0.4,0.1,0.6,0.4c0,0,18.7,32.3,19,32.8C38,36.1,37.8,36.3,37.5,36.4z M77.7,43.9
                                c0.2,0.4,0.5,0.6-0.3,0.8c-0.7,0.3-24.1,8.2-24.6,8.4c-0.5,0.2-0.8,0.3-1.4-0.6s-8.2-14-8.2-14L68.1,32c0.6-0.2,0.8-0.3,1.2,0.3
                                C69.7,33,77.5,43.6,77.7,43.9z M79.3,26.3c-0.6,0.1-9.7,2.4-9.7,2.4l-7.5-10.2c-0.2-0.3-0.4-0.6,0.1-0.7c0.5-0.1,9-1.6,9.4-1.7
                                c0.4-0.1,0.7-0.2,1.2,0.5c0.5,0.6,6.9,8.8,7.2,9.1C80.3,26,79.9,26.2,79.3,26.3z"/>
                        </svg>
                        <h3>Laravel</h3>
                        <p class="lead">Codex is a file-based documentation platform built on top of Laravel 5.3. Use it as stand-alone or integrate it into your own application!</p>
                    </div><!-- /.col-lg-4 -->
                    <div class="col-lg-4 wow slideInUp fadeIn" data-wow-delay="0.7s" data-wow-duration="2s">
                        <img class="img-circle" src="{{ asset('vendor/codex/img/responsive.png') }}" alt="Generic placeholder image" width="140" height="140">
                        <h3>Flexible</h3>
                        <p class="lead">
                            Use Markdown, AsciiDoc, Creole or any other lightweight markup language (LML). Codex knows them all and renders them perfectly. Use a custom parser or add support for other LML's.
                        </p>
                    </div><!-- /.col-lg-4 -->
                </div><!-- /.row -->


            </c-section>

            <!--OVERVIEW-->
            <c-section id="overview" class="scrollspy c-section-dark">
                <header>
                    <h2>Overview</h2>
                    <hr>
                </header>

                <div class="row featurette">
                    <div class="col-md-7">
                        <h2 class="featurette-heading wow slideInLeft fadeIn">Create Beautiful <span class="text-muted">Documentation.</span></h2>
                        <p class="lead wow slideInUp fadeIn">Donec ullamcorper nulla non metus auctor fringilla. Vestibulum id ligula porta felis euismod semper. Praesent commodo cursus magna, vel scelerisque nisl consectetur. Fusce dapibus, tellus ac cursus commodo. </p>
                    </div>
                    <div class="col-md-5"><img class="featurette-image img-fluid mx-auto wow fadeIn" src="http://placehold.it/500x500?text=Generic%20placeholder%20image" alt="Generic placeholder image"></div>
                </div>

                <hr class="section-divider section-divider-light ">

                <div class="row featurette">
                    <div class="col-md-7  push-md-5">
                        <h2 class="featurette-heading wow slideInRight fadeIn">Stunning <span class="text-muted">Features.</span></h2>
                        <p class="lead wow slideInUp fadeIn">Donec ullamcorper nulla non metus auctor fringilla. Vestibulum id ligula porta felis euismod semper. Praesent commodo cursus magna, vel scelerisque nisl consectetur. Fusce dapibus, tellus ac cursus commodo. </p>
                    </div>
                    <div class="col-md-5 pull-md-7"><img class="featurette-image img-fluid mx-auto wow fadeIn" src="http://placehold.it/500x500?text=Generic%20placeholder%20image" alt="Generic placeholder image"></div>
                </div>
            </c-section>


            <!--Documentation 2 -->
            <c-section id="documentation"  class="scrollspy c-section-light wow fadeIn">
                <header>
                    <h2>Documentation</h2>
                    <hr>
                </header>
                <div class="row">
                    <div class="col-md-7">
                        <p class="lead">Codex is very well documented</p>
                    </div>
                    <div class="col-md-5"><a href="/document.html" class="btn btn-primary btn-big">Codex Documentation</a></div>
                </div>


            </c-section>

        </div>

        <c-footer ref="footer">
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <h3>Navigation</h3>
                        <ul>
                            @include('codex::partials.welcome-nav-items')
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <h3>Social</h3>
                    </div>
                    <div class="col-md-4">
                        <h3>Related</h3>
                    </div>
                </div>
            </div>
        </c-footer>

        <c-scroll-to-top></c-scroll-to-top>
    </c-theme>
</div>
@stop
