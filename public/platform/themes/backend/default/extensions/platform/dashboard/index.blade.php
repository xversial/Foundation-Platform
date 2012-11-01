@layout('templates.default')

<!-- Page Title -->
@section('title')
	{{ Lang::line('platform/dashboard::general.title') }}
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
<section id="dashboard">

	<!-- Tertiary Navigation & Actions -->
	<header class="navbar">
		<div class="navbar-inner">
			<div class="container">

			<!-- .btn-navbar is used as the toggle for collapsed navbar content -->
			<a class="btn btn-navbar" data-toggle="collapse" data-target="#tertiary-navigation">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</a>

			<a class="brand" href="#">{{ Lang::line('platform/dashboard::general.title') }}</a>

			<!-- Everything you want hidden at 940px or less, place within here -->
			<div id="tertiary-navigation" class="nav-collapse">
				@widget('platform/menus::menus.nav', 2, 1, 'nav nav-pills', ADMIN)
			</div>

			</div>
		</div>
	</header>

	<hr>

	<div class="quaternary page"></div>

</section>
@endsection
