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
		<meta name="description" content="@yield('meta-description')">
		<meta name="viewport" content="width=device-width">
		<meta name="base_url" content="{{ URL::to('/') }}">

		{{-- Queue assets --}}
		{{ Asset::queue('style', 'platform/less/style.less') }}

		{{ Asset::queue('modernizr', 'modernizr/js/modernizr.js') }}
		{{ Asset::queue('jquery', 'jquery/js/jquery.js') }}
		{{ Asset::queue('bootstrap.alert', 'bootstrap/js/alert.js', 'jquery') }}
		{{ Asset::queue('bootstrap.collapse', 'bootstrap/js/collapse.js', 'jquery') }}
		{{ Asset::queue('bootstrap.dropdown', 'bootstrap/js/dropdown.js', 'jquery') }}
		{{ Asset::queue('bootstrap.tooltip', 'bootstrap/js/tooltip.js', 'jquery') }}
		{{ Asset::queue('bootstrap.popover', 'bootstrap/js/popover.js', 'bootstrap.tooltip') }}
		{{ Asset::queue('platform', 'platform/js/platform.js', 'jquery') }}

		{{-- HTML5 shim, for IE6-8 support of HTML5 elements --}}
		<!--[if lt IE 9]>
			<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->

		<link rel="shortcut icon" href="{{ Asset::getUrl('platform/img/favicon.png') }}">
		<link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{ Asset::getUrl('platform/img/apple-touch-icon-144x144-precomposed.png') }}">
		<link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{ Asset::getUrl('platform/img/apple-touch-icon-114x114-precomposed.png') }}">
		<link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{ Asset::getUrl('platform/img/apple-touch-icon-72x72-precomposed.png') }}">
		<link rel="apple-touch-icon-precomposed" href="{{ Asset::getUrl('platform/img/apple-touch-icon-precomposed.png') }}">

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

		<div class="container">

			<nav class="navbar navbar-default" role="navigation">

				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
					<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="{{ URL::to('/') }}">@setting('platform.site.title')</a>
				</div>

				<div class="collapse navbar-collapse">

					<ul class="nav navbar-nav">
						<li><a target="_blank" href="https://www.cartalyst.com/licence">License</a></li>
						<li><a target="_blank" href="https://www.cartalyst.com/manual/platform">Documentation</a></li>
					</ul>

					@widget('platform/menus::nav.show', array('main', 0, 'nav navbar-nav navbar-right'))

				</div>

			</nav>

			{{-- Notifications --}}
			@include('partials/notifications')

			{{-- Page content --}}
			@section('content')
			@show

		</div>

		{{-- Compiled scripts --}}
		@foreach (Asset::getCompiledScripts() as $script)
			<script src="{{ $script }}"></script>
		@endforeach

		{{-- Call custom inline scripts --}}
		@section('scripts')
		@show

	</body>
</html>
