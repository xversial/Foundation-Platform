@layout('installer::template')

@section('title')
{{ Lang::line('installer::update.title')->get() }} | {{ Lang::line('installer::general.step_1.title')->get() }}
@endsection

@section('navigation')
	<h1>{{ Lang::line('installer::update.step_1.title') }}</h1>
	<p class="step">{{ Lang::line('installer::update.step_1.tagline') }}</p>
	<div class="breadcrumbs">
		<ul class="nav">
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
				<form id="filesystem-form" class="form-horizontal" method="POST" accept-char="UTF-8">
				<input type="hidden" name="{{ Session::csrf_token }}" value="{{ Session::token() }}">

				<!-- Form Actions -->
				<div class="form-actions">
					<div class="pull-right">
						<button type="submit" id="continue-btn" class="btn btn-large">
							{{ Lang::line('installer::button.next') }}
						</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</section>
@endsection
