@layout('installer::template')

@section('title')
{{ Lang::line('installer::update.title') }} | {{ Lang::line('installer::update.step_1.title') }}
@endsection

@section('scripts')
<script>
	$(document).ready(function() {

		Validate.setup($("#update-form"));

	});
</script>
@endsection

@section('navigation')
	<h1>{{ Lang::line('installer::update.step_1.title') }}</h1>
	<p class="step">{{ Lang::line('installer::update.step_1.tagline') }}</p>
	<div class="breadcrumbs">
		<ul class="nav">
			<li class="active"><span>{{ Lang::line('installer::update.step_1.step') }}</span> {{ Lang::line('installer::update.step_1.step_description') }}</li>
			<li><span>{{ Lang::line('installer::update.step_2.step') }}</span> {{ Lang::line('installer::update.step_2.step_description') }}</li>
		</ul>
	</div>
@endsection

@section('content')
<section id="updates">
	<header>
		<h2>{{ Lang::line('installer::update.step_1.description', array('code_version' => $code_version, 'installed_version' => $installed_version)) }}</h2>
	</header>
	<hr>
	<div class="container-fluid">
		<div class="row-fluid">
			<div class="span12">
				<form id="update-form" class="form-horizontal" method="POST" accept-char="UTF-8">
					<fieldset>
						<legend>{{ Lang::line('installer::form.update.legend') }}</legend>

						<input type="hidden" name="{{ Session::csrf_token }}" value="{{ Session::token() }}">

						<div class="control-group">
							<label for="disclaimer" class="control-label">{{ Lang::line('installer::form.database.disclaimer') }}</label>
							<div class="controls">
								<label class="checkbox">
									<input type="checkbox" name="disclaimer" value="1" required>
									{{ Lang::line('installer::form.update.disclaimer_help') }}
								</label>
							</div>
						</div>

						<!-- Form Actions -->
						<div class="form-actions">
							<div class="pull-right">
								<button type="submit" id="continue-btn" class="btn btn-large">
									{{ Lang::line('installer::button.next') }}
								</button>
							</div>
						</div>
					</fieldset>
				</form>
			</div>
		</div>
	</div>
</section>
@endsection
