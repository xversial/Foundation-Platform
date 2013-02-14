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
		<meta name="base_url" content="{{ Request::root().'/'.ADMIN_URI }}">

		<!-- Queue template assets -->
		{{ Asset::queue('style', 'styles/less/style.less') }}

		{{ Asset::queue('modernizr', 'js/vendor/modernizr/modernizr.js') }}
		{{ Asset::queue('jquery', 'js/vendor/jquery/jquery.js') }}
		{{ Asset::queue('helpers', 'js/vendor/platform/helpers.js', array('jquery')) }}
		{{ Asset::queue('plugins', 'js/plugins.js', array('jquery')) }}
		{{ Asset::queue('script', 'js/script.js', array('jquery')) }}

		<!-- Call partial assets -->
		@yield('assets')

		<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
		<!--[if lt IE 9]>
			<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->

		<link rel="shortcut icon" href="{{ Asset::getUrl('img/favicon.png') }}">
		<link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{ Asset::getUrl('img/apple-touch-icon-144x144-precomposed.png') }}">
		<link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{ Asset::getUrl('img/apple-touch-icon-114x114-precomposed.png') }}">
		<link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{ Asset::getUrl('img/apple-touch-icon-72x72-precomposed.png') }}">
		<link rel="apple-touch-icon-precomposed" href="{{ Asset::getUrl('img/apple-touch-icon-precomposed.png') }}">

		<!-- Compile styles -->
		@foreach (Asset::getCompiledStyles() as $style)
			<link href="{{ $style }}" rel="stylesheet">
		@endforeach

		<!-- Call custom inline styles -->
		@yield('styles')

	</head>
	<body>
		<!--[if lt IE 7]>
		<p class="chromeframe">You are using an outdated browser. <a href="http://browsehappy.com/">Upgrade your browser today</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to better experience this site.</p>
		<![endif]-->

		<div id="base">

			<header class="navbar">
				<div class="navbar-inner">
					<div class="container-fluid">
						<a class="btn btn-navbar" data-toggle="collapse" data-target="#primary-navigation">
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</a>

						<a class="brand" href="{{ Request::root().'/'.ADMIN_URI }}">{{ Config::get('platform.site.title') }}</a>

						<ul class="nav pull-right">
							<li class="divider-vertical"></li>
							<li>
								<a href="{{ Request::root() }}" target="_self">
									<i class="icon-home"></i> <span>Home</span>
								</a>
							</li>
							<li class="divider-vertical"></li>
							<li>
								<a href="{{ URL::to('/logout') }}" target="_self">
									<i class="icon-signout"></i> <span>Logout</span>
								</a>
							</li>
							<li class="divider-vertical"></li>
						</ul>
						<div id="primary-navigation" class="nav-collapse collapse">
							@widget('platform/menus::nav.show', array('admin', 1, 'nav', ADMIN_URI))
						</div><!--/.nav-collapse -->
					</div>
				</div>
			</header><!--/.Mobile Navigation -->

			<div class="primary page container-fluid">

				<div class="row-fluid hidden-desktop">
					<div class="span12">
						<nav class="secondary-navigation">
							@widget('platform/menus::nav.show', array(1, 1, 'nav nav-stacked nav-pills', ADMIN_URI))
						</nav>
					</div>
				</div>

				<div class="tabbable tabs-left">

					@widget('platform/menus::nav.show', array(1, 1, 'secondary-navigation nav nav-tabs visible-desktop', ADMIN_URI))

					<div class="secondary page tab-content">
						@yield('content')
					</div>
				</div>

			</div>
			<div id="push"></div>

		</div><!--/.base-->

		<footer>
			{{ Config::get('platform.site.copyright') }}
		</footer>

		<!-- Compile scripts -->
		@foreach (Asset::getCompiledScripts() as $script)
			<script src="{{ $script }}"></script>
		@endforeach

		<!-- Call custom inline scripts -->
		@yield('scripts')

	</body>

</html>
