@layout('templates.default')

<!-- Page Title -->
@section('title')
	{{ Lang::line('users::general.users.create.title') }}
@endsection

<!-- Queue Styles | e.g Theme::queue_asset('name', 'path_to_css', 'dependency')-->

<!-- Styles -->
@section ('styles')
@endsection

<!-- Queue Scripts -->
{{ Theme::queue_asset('validate', 'js/vendor/platform/validate.js', 'jquery') }}

<!-- Scripts -->
@section('scripts')
<script>
	$(document).ready(function() {

		//Match Password
		var password = document.getElementById("password"),
			passwordConfirm = document.getElementById("password_confirmation");

		$('#password, #password_confirmation').keyup(function() {
			if(passwordConfirm.value !== password.value) {
				passwordConfirm.setCustomValidity("Your password doesn't match");
			} else {
				passwordConfirm.setCustomValidity("");
			}
		});

		Validate.setup($("#create-form"));
	});
</script>
@endsection

<!-- Page Content -->
@section('content')
	<section id="users">

		<header class="clearfix">
			<div class="pull-left">
				<h1>{{ Lang::line('users::general.users.create.title') }}</h1>
				<p>{{ Lang::line('users::general.users.create.description') }}</p>
			</div>
			<nav class="tertiary-navigation pull-right visible-desktop">
				@widget('platform.menus::menus.nav', 2, 1, 'nav nav-pills', ADMIN)
			</nav>
		</header>

		<hr>

		<div class="row-fluid">
			<div class="quaternary span12">
				@widget('platform.users::admin.user.form.create')
			</div>
		</div>

	</section>
@endsection
