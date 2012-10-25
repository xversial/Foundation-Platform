@layout('installer::template')

@section('title')
{{ Lang::line('installer::install.title')->get() }} | {{ Lang::line('installer::general.step_3.title')->get() }}
@endsection

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

		Validate.setup($("#user-form"));

	});
</script>
@endsection

@section('navigation')
	<h1>{{ Lang::line('installer::install.step_3.title') }}</h1>
	<p class="step">{{ Lang::line('installer::install.step_3.tagline') }}</p>
	<div class="breadcrumbs">
		<ul class="nav">
			<ul class="nav">
			<li><span>{{ Lang::line('installer::install.step_1.step') }}</span> {{ Lang::line('installer::install.step_1.step_description') }}</li>
			<li><span>{{ Lang::line('installer::install.step_2.step') }}</span> {{ Lang::line('installer::install.step_2.step_description') }}</li>
			<li class="active"><span>{{ Lang::line('installer::install.step_3.step') }}</span> {{ Lang::line('installer::install.step_3.step_description') }}</li>
			<li><span>{{ Lang::line('installer::install.step_4.step') }}</span> {{ Lang::line('installer::install.step_4.step_description') }}</li>
		</ul>
	</div>
@endsection


@section('content')
<section id="checks">
	<header>
		<h2>{{ Lang::line('installer::install.step_3.description') }}</h2>
	</header>
	<hr>
	<div class="container-fluid">
		<div class="row-fluid">
			<div class="span12">
				<form id="user-form" class="form-horizontal" method="POST" accept-char="UTF-8">
				<input type="hidden" name="{{ Session::csrf_token }}" value="{{ Session::token() }}">
					<fieldset class="well">
						<legend>{{ Lang::line('installer::form.user.legend') }}</legend>

						<!-- User First Name -->
						<div class="control-group">
							<label class="control-label" for="first_name">{{ Lang::line('installer::form.user.first_name') }}</label>
							<div class="controls">
								<div class="input-append">
									<input type="text" name="first_name" id="first_name" value="" placeholder="{{ Lang::line('installer::form.user.first_name') }}" required>
									<span class="add-on"><i class="icon-user"></i></span>
								</div>
								<span class="help-block">{{ Lang::line('installer::form.user.first_name_help') }}</span>
							</div>
						</div>

						<!-- User Last Name -->
						<div class="control-group">
							<label class="control-label" for="last_name">{{ Lang::line('installer::form.user.last_name') }}</label>
							<div class="controls">
								<div class="input-append">
									<input type="text" name="last_name" id="last_name" value="" placeholder="{{ Lang::line('installer::form.user.last_name') }}" required>
									<span class="add-on"><i class="icon-user"></i></span>
								</div>
								<span class="help-block">{{ Lang::line('installer::form.user.last_name_help') }}</span>
							</div>
						</div>

						<!-- User Email Addres -->
						<div class="control-group">
							<label class="control-label" for="email">{{ Lang::line('installer::form.user.email') }}</label>
							<div class="controls">
								<div class="input-append">
									<input type="email" name="email" id="email" value="" placeholder="{{ Lang::line('installer::form.user.email') }}" required>
									<span class="add-on"><i class="icon-envelope"></i></span>
								</div>
								<span class="help-block">{{ Lang::line('installer::form.user.email_help') }}</span>
							</div>
						</div>

						<!-- User Password -->
						<div class="control-group">
							<label class="control-label" for="password">{{ Lang::line('installer::form.user.password') }}</label>
							<div class="controls">
								<div class="input-append">
									<input type="password" name="password" id="password" placeholder="{{ Lang::line('installer::form.user.password') }}" required>
									<span class="add-on"><i class="icon-lock"></i></span>
								</div>
								<span class="help-block">{{ Lang::line('installer::form.user.password_help') }}</span>
							</div>
						</div>

						<!-- User Password Confirm -->
						<div class="control-group">
							<label class="control-label" for="password_confirmation">{{ Lang::line('installer::form.user.password_confirm') }}</label>
							<div class="controls">
								<div class="input-append">
									<input type="password" name="password_confirmation" id="password_confirmation" placeholder="{{ Lang::line('installer::form.user.password_confirm') }}" required>
									<span class="add-on"><i class="icon-lock"></i></span>
								</div>
								<span class="help-block">{{ Lang::line('installer::form.user.password_confirm_help') }}</span>
							</div>
						</div>

					</fieldset>

					<div class="form-actions">
						<div class="pull-right">
							<button type="submit" class="btn btn-large">{{ Lang::line('installer::button.next') }}</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>
@endsection
