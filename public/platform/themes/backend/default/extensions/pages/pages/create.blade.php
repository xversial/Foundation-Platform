@layout('templates.default')

<!-- Page Title -->
@section('title')
	Create a Page
@endsection

<!-- Queue Styles | e.g Theme::queue_asset('name', 'path_to_css', 'dependency')-->

<!-- Styles -->
@section ('styles')
@endsection

<!-- Queue Scripts -->
{{ Theme::queue_asset('validate', 'js/vendor/platform/validate.js', 'jquery') }}
{{ Theme::queue_asset('helpers', 'js/vendor/platform/helpers.js', 'jquery') }}

<!-- Scripts -->
@section('scripts')
<script type="text/javascript">
	(function($) {
		$('#name').on('blur', function() { $('#slug').val($(this).slugify()) });
	})(jQuery);
</script>
@endsection

<!-- Page Content -->
@section('content')

<section id="users">

	<!-- Tertiary Navigation & Actions -->
	<header class="navbar">
		<div class="navbar-inner">
			<div class="container">

			<!-- .btn-navbar is used as the toggle for collapsed navbar content -->
			<a class="btn btn-navbar" data-toggle="collapse" data-target="#tertiary-navigation">
				<span class="icon-reorder"></span>
			</a>

			<a class="brand" href="#">Page Management</a>

			<!-- Everything you want hidden at 940px or less, place within here -->
			<div id="tertiary-navigation" class="nav-collapse">
				@widget('platform.menus::menus.nav', 2, 1, 'nav nav-pills', ADMIN)
			</div>

			</div>
		</div>
	</header>

	<hr>

	<div class="row-fluid">
		<div class="span12">
			@widget('platform.pages::admin.pages.form.create')
		</div>
	</div>

</section>

@endsection
