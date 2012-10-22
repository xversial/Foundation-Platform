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
{{ Theme::queue_asset('validate', 'js/validate.js', 'jquery') }}

<!-- Scripts -->
@section('scripts')
<script>

</script>
@endsection

<!-- Page Content -->
@section('content')

<section id="users">

	<header class="head row-fluid">
		<div class="span4">
			<h1>Create Page</h1>
			<p>Create a page for your site</p>
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
