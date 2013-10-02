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
		{{-- Workaround, until the LESS PHP Compiler get's update FFS! --}}
		{{ Asset::queue('bootstrap', 'css/bootstrap/bootstrap.css') }}
		{{ Asset::queue('font-awesome', 'css/font-awesome/font-awesome.css') }}
		{{ Asset::queue('style', 'css/style.css') }}
		{{-- Asset::queue('style', 'less/style.less') --}}

		{{ Asset::queue('modernizr', 'js/modernizr/modernizr.js') }}
		{{ Asset::queue('jquery', 'js/jquery/jquery.js') }}
		{{ Asset::queue('collapse', 'js/bootstrap/collapse.js', array('jquery')) }}
		{{ Asset::queue('dropdown', 'js/bootstrap/dropdown.js', array('jquery')) }}
		{{ Asset::queue('modal', 'js/bootstrap/modal.js', array('jquery')) }}
		{{ Asset::queue('tooltip', 'js/bootstrap/tooltip.js', array('jquery')) }}
		{{ Asset::queue('scripts', 'js/scripts.js', array('jquery')) }}

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

		<div id="wrap">

			<!--[if lt IE 7]>
			<p class="chromeframe">You are using an outdated browser. <a href="http://browsehappy.com/">Upgrade your browser today</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to better experience this site.</p>
			<![endif]-->

			<nav class="navbar navbar-default navbar-static-top" role="navigation">
				<div class="container">

					<!-- Brand and toggle get grouped for better mobile display -->
					<div class="navbar-header">
						<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						<a class="navbar-brand" href="{{ URL::toAdmin('/') }}">@setting('platform.site.title')</a>
					</div>

					<!-- Collect the nav links, forms, and other content for toggling -->
					<div class="collapse navbar-collapse navbar-ex1-collapse">
						@widget('platform/menus::nav.show', array('admin', 2, 'nav navbar-nav', admin_uri()))

						@widget('platform/menus::nav.show', array('system', 0, 'nav navbar-nav navbar-right'))
					</div>

				</div>
			</nav>

			<div class="container">

				{{-- Notifications --}}
				@include('partials/notifications')

				{{-- Page content --}}
				@section('content')
				@show

			</div>

		</div>

		{{-- Footer --}}
		<footer id="footer">
			<div class="container">

				<span>
					<a href="{{ URL::to('http://www.cartalyst.com/licence') }}" target="_blank">
						Copyright &copy; 2011 - 2013 Cartalyst LLC
					</a>
				</span>

				<span class="pull-right">Platform Version {{{ PLATFORM_VERSION }}}</span>

			</div>
		</footer>

		{{-- Modals --}}
		@include('partials/modals')

		{{-- Compiled scripts --}}
		@foreach (Asset::getCompiledScripts() as $script)
			<script src="{{ $script }}"></script>
		@endforeach

		{{-- Call custom inline scripts --}}
		@section('scripts')
		@show

	</body>
</html>
