@layout('installer::template')

@section('title')
{{ Lang::line('installer::install.title')->get() }} | {{ Lang::line('installer::general.step_2.title')->get() }}
@endsection

@section('scripts')
<script>
	$(document).ready(function() {

		Validate.setup($("#database-form"));

	});
</script>
@endsection

@section('navigation')
	<h1>{{ Lang::line('installer::install.step_2.title') }}</h1>
	<p class="step">{{ Lang::line('installer::install.step_2.tagline') }}</p>
	<div class="breadcrumbs">
		<ul class="nav">
			<ul class="nav">
			<li><span>{{ Lang::line('installer::install.step_1.step') }}</span> {{ Lang::line('installer::install.step_1.step_description') }}</li>
			<li class="active"><span>{{ Lang::line('installer::install.step_2.step') }}</span> {{ Lang::line('installer::install.step_2.step_description') }}</li>
			<li><span>{{ Lang::line('installer::install.step_3.step') }}</span> {{ Lang::line('installer::install.step_3.step_description') }}</li>
			<li><span>{{ Lang::line('installer::install.step_4.step') }}</span> {{ Lang::line('installer::install.step_4.step_description') }}</li>
		</ul>
	</div>
@endsection


@section('content')
<section id="checks">
	<header>
		<h2>{{ Lang::line('installer::install.step_2.description') }}</h2>
	</header>
	<hr>
	<div class="container-fluid">
		<div class="row-fluid">
			<div class="span12">
				<form id="database-form" class="form-horizontal" method="POST" accept-char="UTF-8">
				<input type="hidden" name="{{ Session::csrf_token }}" value="{{ Session::token() }}">
					<fieldset class="well">
						<legend>{{ Lang::line('installer::form.database.legend') }}</legend>
						<!-- Database Driver Select -->
						<div class="control-group">
							<label class="control-label" for="driver">{{ Lang::line('installer::form.database.driver') }}</label>
							<div class="controls">

								<div class="input-append">
									<select name="driver" id="driver" required>
										<option value="">{{ Lang::line('installer::form.database.driver') }}</option>
										@foreach ($drivers as $driver => $label)
											<option value="{{ $driver }}" {{ ($driver == $credentials['driver']) ? 'selected' : null}}>{{ $label }}</option>
										@endforeach
									</select>
									<span class="add-on"><i class="icon-dashboard"></i></span>
								</div>
								<span class="help-block">{{ Lang::line('installer::form.database.driver_help') }}</span>
							</div>
						</div>

						<!-- Database Host -->
						<div class="control-group">
							<label class="control-label" for="host">{{ Lang::line('installer::form.database.server') }}</label>
							<div class="controls">
								<div class="input-append">
									<input type="text" name="host" id="host" value="{{ $credentials['host'] }}" placeholder="{{ Lang::line('installer::form.database.server') }}" required>
									<span class="add-on"><i class="icon-hdd"></i></span>
								</div>
								<span class="help-block">{{ Lang::line('installer::form.database.server_help') }}</span>
							</div>
						</div>

						<!-- Database Username -->
						<div class="control-group">
							<label class="control-label" for="username">{{ Lang::line('installer::form.database.username') }}</label>
							<div class="controls">
								<div class="input-append">
									<input type="text" name="username" id="username" value="{{ $credentials['username'] }}" placeholder="{{ Lang::line('installer::form.database.username') }}" required>
									<span class="add-on"><i class="icon-user"></i></span>
								</div>
								<span class="help-block">{{ Lang::line('installer::form.database.username_help') }}</span>
							</div>
						</div>

						<!-- Database Password -->
						<div class="control-group">
							<label class="control-label" for="password">{{ Lang::line('installer::form.database.password') }}</label>
							<div class="controls">
								<div class="input-append">
									<input type="password" name="password" id="password" placeholder="{{ Lang::line('installer::form.database.password') }}">
									<span class="add-on"><i class="icon-lock"></i></span>
								</div>
								<span class="help-block">{{ Lang::line('installer::form.database.password_help') }}</span>
							</div>
						</div>

						<!-- Database Name -->
						<div class="control-group">
							<label class="control-label" for="database">{{ Lang::line('installer::form.database.database') }}</label>
							<div class="controls">
								<div class="input-append">
									<input type="text" name="database" id="database" value="{{ $credentials['database'] }}" placeholder="{{ Lang::line('installer::form.database.database') }}" required>
									<span class="add-on"><i class="icon-briefcase"></i></span>
								</div>
								<span class="help-block">{{ Lang::line('installer::form.database.database_help') }}</span>
							</div>
						</div>

						<!-- Drop Table Warning -->
						<div class="control-group">
							<div class="controls">
								<label for="disclaimer">{{ Lang::line('installer::form.database.disclaimer') }}
									<input type="checkbox" name="disclaimer" value="" required>
								</label>
								<span class="help-block">{{ Lang::line('installer::form.database.disclaimer_help') }}</span>
							</div>
						</div>

						<p class="messages alert"></p>

					</fieldset>

					<div class="form-actions">
						<div class="pull-right">
							<a class="btn btn-large" href="{{URL::to('installer/install/step_1');}}">{{ Lang::line('installer::button.previous') }}</a>
							<button type="submit" class="btn btn-large" disabled>{{ Lang::line('installer::button.next') }}</button>
						</div>
					</div>
				</form>
			</div>
		</div>
</section>
@endsection
