<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<title>@yield('title')</title>
		<meta name="description" content="">
		<meta name="viewport" content="width=device-width">
		<meta name="base_url" content="{{ Request::root() }}">

		{{ Asset::queue('style', 'less/style.less') }}

		{{ Asset::queue('modernizr', 'js/vendor/modernizr/modernizr.js') }}
		{{ Asset::queue('jquery', 'js/vendor/jquery/jquery.js') }}
		{{ Asset::queue('helpers', 'js/vendor/platform/helpers.js', array('jquery')) }}
		{{ Asset::queue('plugins', 'js/plugins.js', array('jquery')) }}
		{{ Asset::queue('script', 'js/script.js', array('jquery')) }}

		@yield('assets')

		<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
		<!--[if lt IE 9]>
			<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->

		<link rel="shortcut icon" href="{{ Asset::url('img/favicon.png') }}">
		<link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{ Asset::url('img/apple-touch-icon-144x144-precomposed.png') }}">
		<link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{ Asset::url('img/apple-touch-icon-114x114-precomposed.png') }}">
		<link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{ Asset::url('img/apple-touch-icon-72x72-precomposed.png') }}">
		<link rel="apple-touch-icon-precomposed" href="{{ Asset::url('img/apple-touch-icon-precomposed.png') }}">

		<style>
		{{ Asset::dumpStyles() }}
		</style>

		@yield('styles')

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
					<a class="brand" href="{{ Request::root() }}">Site Title Here</a>
					<div class="nav-collapse collapse">
						Nav goes here
					</div><!--/.nav-collapse -->
				</div>
			</div>
		</div>

		<div class="container">

			@yield('content')

			<hr>

			<footer>
				@content('copyright')
			</footer>

		</div> <!-- /container -->

		<script>
		{{ Asset::dumpScripts() }}
		</script>

		@yield('scripts')

	</body>
</html>