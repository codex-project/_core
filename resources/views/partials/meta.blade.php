<?php

$sizes = [ 57, 60, 72, 76, 114, 120, 144, 152, 180 ];

?>
<link rel="apple-touch-icon" href="/apple-touch-icon.png">
<link rel="apple-touch-icon" sizes="57x57" href="/apple-touch-icon-57x57.png">
<link rel="apple-touch-icon" sizes="60x60" href="/apple-touch-icon-60x60.png">
<link rel="apple-touch-icon" sizes="72x72" href="/apple-touch-icon-72x72.png">
<link rel="apple-touch-icon" sizes="76x76" href="/apple-touch-icon-76x76.png">
<link rel="apple-touch-icon" sizes="114x114" href="/apple-touch-icon-114x114.png">
<link rel="apple-touch-icon" sizes="120x120" href="/apple-touch-icon-120x120.png">
<link rel="apple-touch-icon" sizes="144x144" href="/apple-touch-icon-144x144.png">
<link rel="apple-touch-icon" sizes="152x152" href="/apple-touch-icon-152x152.png">
<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon-180x180.png">


@foreach($metas as $meta)
    <meta @foreach($meta as $key => $value) {{$key}}="{{$value}}" @endforeach >
@endforeach

@if(isset($googleVerification))
    <meta name="google-site-verification" content="{{ $googleVerification }}">
@endif

<meta name="google-site-verification" content="ZzhVyEFwb7w3e0-uOTltm8Jsck2F5StVihD0exw2fsA">

@if(isset($googleAnalytics))
    <meta name="google-analytics" content="{{ $googleAnalytics }}">
@endif

@if(isset($facebookAppId))
    <meta property="fb:app_id" content="$facebookAppId">
@endif

<meta property="og:title" content="The Rock"/><z
<meta property="og:type" content="video.movie"/>
<meta property="og:url" content="http://www.imdb.com/title/tt0117500/"/>
<meta property="og:image" content="http://ia.media-imdb.com/images/rock.jpg"/>

<meta property="og:audio" content="http://example.com/bond/theme.mp3"/>
<meta property="og:description" content="Sean Connery found fame and fortune as the suave, sophisticated British agent, James Bond."/>
<meta property="og:determiner" content="the"/>
<meta property="og:locale" content="en_GB"/>
<meta property="og:locale:alternate" content="fr_FR"/>
<meta property="og:locale:alternate" content="es_ES"/>
<meta property="og:site_name" content="IMDb"/>
<meta property="og:video" content="http://example.com/bond/trailer.swf"/>
