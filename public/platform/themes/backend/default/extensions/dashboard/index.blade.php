@layout('templates.default')

<!-- Page Title -->
@section('title')
	{{ Lang::line('dashboard::general.title') }}
@endsection

<!-- Queue Styles | e.g Theme::queue_asset('name', 'path_to_css', 'dependency')-->

<!-- Styles -->
@section ('styles')
@endsection

<!-- Queue Scripts | e.g. Theme::queue_asset('name', 'path_to_js', 'dependency')-->

<!-- Scripts -->
@section('scripts')
@endsection

<!-- Page Content -->
@section ('content')
<section id="dashbaord">

	<header class="clearfix">
			<div class="pull-left">
				<h1>{{ Lang::line('dashboard::general.title') }}</h1>
				<p>{{ Lang::line('dashboard::general.description') }}</p>
			</div>
			<nav class="tertiary-navigation pull-right visible-desktop">
				@widget('platform.menus::menus.nav', 2, 1, 'nav nav-pills', ADMIN)
			</nav>
	</header>

	<hr>

</section>
@endsection
