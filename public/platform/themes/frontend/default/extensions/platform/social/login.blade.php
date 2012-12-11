@layout('templates.default')

<!-- Title -->
@section('title')
	@get.settings.site.title - {{ Lang::line('platform/users::form.auth.login.legend') }}
@endsection

<!-- Queue Styles | e.g Theme::queue_asset('name', 'path_to_css', 'dependency') -->

<!-- Styles -->
@section ('styles')
@endsection

{{ Theme::queue_asset('validate', 'js/validate.js', 'jquery') }}
{{ Theme::queue_asset('social-login', 'platform/social::js/login.js', 'jquery') }}
{{ Theme::queue_asset('bootstrap-tab', 'js/bootstrap/tab.js', 'jquery') }}

<!-- Scripts -->
@section('scripts')
@endsection

<!-- Content -->
@section('content')
	<section id="login" class="well">
		@widget('platform/social::form.login')
	</section>
@endsection
