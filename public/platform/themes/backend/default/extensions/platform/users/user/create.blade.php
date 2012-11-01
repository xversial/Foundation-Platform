@layout('templates.default')

<!-- Page Title -->
@section('title')
	{{ Lang::line('platform/users::general.users.create.title') }}
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

	<!-- Tertiary Navigation & Actions -->
	<header class="navbar">
		<div class="navbar-inner">
			<div class="container">

			<!-- .btn-navbar is used as the toggle for collapsed navbar content -->
			<a class="btn btn-navbar" data-toggle="collapse" data-target="#tertiary-navigation">
				<span class="icon-reorder"></span>
			</a>

			<a class="brand" href="#">{{ Lang::line('platform/users::general.users.create.title') }}</a>

			<!-- Everything you want hidden at 940px or less, place within here -->
			<div id="tertiary-navigation" class="nav-collapse">
				@widget('platform/menus::menus.nav', 2, 1, 'nav nav-pills', ADMIN)
			</div>

			</div>
		</div>
	</header>

	<hr>

	<div class="quaternary page">
		@widget('platform/users::admin.user.form.create')
	</div>

</section>
@endsection
