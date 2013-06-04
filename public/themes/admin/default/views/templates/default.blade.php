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
		<meta name="admin_url" content="{{ URL::toAdmin('/') }}">

		{{-- Queue template assets --}}
		{{ Asset::queue('style', 'styles/less/style.less') }}

		{{ Asset::queue('modernizr', 'js/vendor/modernizr/modernizr.js') }}
		{{ Asset::queue('jquery', 'js/vendor/jquery/jquery.js') }}
		{{ Asset::queue('tooltip', 'js/vendor/bootstrap/tooltip.js', 'jquery') }}
		{{ Asset::queue('helpers', 'js/vendor/platform/helpers.js', array('jquery')) }}
		{{ Asset::queue('script', 'js/script.js', array('tooltip')) }}

		{{-- Call partial assets --}}
		@section('assets')
		@show

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

		{{-- Notifications --}}
		@include('partials/notifications')

		<div id="base">
			<aside class="sidebar">

				<a class="brand" href="{{ URL::toAdmin('/') }}" title="@setting('platform.site.tagline')">
					<img src="{{ Asset::getUrl('img/brand.png') }}" alt="">
					<span>@setting('platform.site.title')</span>
				</a>

				<nav>@widget('platform/menus::nav.show', array('admin', 1, '', admin_uri()))</nav>

				<a href="#" class="sidebar-toggle"></a>

				@include('partials/footer')

			</aside>
			<article class="page">

				<nav class="system-navigation">
					@widget('platform/menus::nav.show', array('system', 1, ''))
				</nav>

				<nav class="secondary-navigation">
					@widget('platform/menus::nav.show', array(1, 1, 'nav nav-tabs', admin_uri()))
				</nav>

				@section('content')
				@show

			</article>
		</div>

		@include('modals/delete')

		{{-- Compiled scripts --}}
		@foreach (Asset::getCompiledScripts() as $script)
		<script src="{{ $script }}"></script>
		@endforeach

		{{-- Call custom inline scripts --}}
		@section('scripts')
		@show
	</body>
</html>
