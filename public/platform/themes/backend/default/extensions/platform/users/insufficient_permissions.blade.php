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
<section id="dashbaord">

	<div class="messages">
		<div class="alert alert-error">
			{{ Lang::line('platform/users::messages.insufficient_permissions') }}
		</div>
	</div>

</section>
@endsection
