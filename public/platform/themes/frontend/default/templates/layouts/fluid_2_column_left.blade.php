@layout('templates.fluid')

<!-- Title -->
@section('title')
	@get('platform/settings::site.title')
@endsection

<!-- Queue Styles | e.g Theme::queue_asset('name', 'path_to_css', 'dependency') -->

<!-- Styles -->
@section ('styles')
@endsection

<!-- Queue Scripts | e.g. Theme::queue_asset('name', 'path_to_js', 'dependency') -->

<!-- Scripts -->
@section('scripts')
@endsection

<!-- Content -->
@section('content')
<div class="span3">
	<div class="well sidebar-nav">
		@widget('platform/menus::menus.nav', 'main', 1, 'nav nav-list')
	</div>
</div>
<div class="span9">
	{{ $content }}
</div>
@endsection
