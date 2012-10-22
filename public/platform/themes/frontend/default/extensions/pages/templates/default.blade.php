@layout('templates.default')

<!-- Title -->
@section('title')
	@get.settings.site.title
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
<section id="page default">

	<h1>{{ $name }}</h1>

	{{ $content }}

</section>
@endsection
