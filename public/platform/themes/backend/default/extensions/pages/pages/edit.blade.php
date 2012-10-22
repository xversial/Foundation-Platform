@layout('templates.default')

<!-- Page Title -->
@section('title')
	Edit a Page
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
			<h1>Edit Page</h1>
			<p>Edit a page for your site</p>
		</div>
	</header>

	<hr>

	<div class="row-fluid">
		<div class="span12">
			@widget('platform.pages::admin.pages.form.edit', $id)
		</div>
	</div>

</section>

@endsection
