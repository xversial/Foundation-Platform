<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<title>
			@section('title')
			{{ Config::get('platform.site.title') }}
			@show
		</title>
		<meta name="description" content="">
		<meta name="viewport" content="width=device-width">
		<meta name="base_url" content="{{ URL::to('/') }}">

		{{-- Queue template assets --}}
		{{ Asset::queue('style', 'less/style.less') }}

		{{ Asset::queue('modernizr', 'js/modernizr/modernizr.js') }}
		{{ Asset::queue('jquery', 'js/jquery/jquery.js') }}
		{{ Asset::queue('helpers', 'js/platform/helpers.js', array('jquery')) }}
		{{ Asset::queue('plugins', 'js/plugins.js', array('jquery')) }}
		{{ Asset::queue('script', 'js/script.js', array('jquery')) }}
		{{ Asset::queue('collapse', 'js/bootstrap/collapse.js', array('jquery')) }}

		{{-- HTML5 shim, for IE6-8 support of HTML5 elements --}}
		<!--[if lt IE 9]>
			<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->

		<link rel="shortcut icon" href="{{ Asset::getUrl('img/favicon.png') }}">
		<link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{ Asset::getUrl('img/apple-touch-icon-144x144-precomposed.png') }}">
		<link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{ Asset::getUrl('img/apple-touch-icon-114x114-precomposed.png') }}">
		<link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{ Asset::getUrl('img/apple-touch-icon-72x72-precomposed.png') }}">
		<link rel="apple-touch-icon-precomposed" href="{{ Asset::getUrl('img/apple-touch-icon-precomposed.png') }}">

		{{-- Compiled styles --}}
		@foreach (Asset::getCompiledStyles() as $style)
			<link href="{{ $style }}" rel="stylesheet">
		@endforeach

		{{-- Call custom inline styles --}}
		@section('styles')
		@show
	</head>

	<body>

		<!--[if lt IE 7]>
		<p class="chromeframe">You are using an outdated browser. <a href="http://browsehappy.com/">Upgrade your browser today</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to better experience this site.</p>
		<![endif]-->

		<div class="navbar navbar navbar-fixed-top">
			<div class="navbar-inner">
				<div class="container">
					<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</a>

					<a class="brand" href="{{ URL::to('/') }}">@setting('platform.site.title')</a>

					<div class="nav-collapse collapse">
						@widget('platform/menus::nav.show', array('main', 1, 'nav'))
					</div>
				</div>
			</div>
		</div>

		<div class="page container">

			@include('partials/notifications')

			@section('content')
			@show

		</div>
		<hr>
		<footer>
			<img src="{{ Asset::getUrl('img/brand-cartalyst.png') }}" alt="Cartalyst Logo" />
			<p class="copyright">Created, developed, and designed by <a href="http://twitter.com/#!/Cartalyst">@Cartalyst</a></p>
			<p class="licence">The BSD 3-Clause License - Copyright © 2011-2013, Cartalyst LLC</p>
		</footer>

		{{-- Compiled scripts --}}
		@foreach (Asset::getCompiledScripts() as $script)
			<script src="{{ $script }}"></script>
		@endforeach

		{{-- Call custom inline scripts --}}
		@section('scripts')
		@show
	</body>
</html>
