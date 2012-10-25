@layout('installer::template')

@section('title')
{{ Lang::line('installer::update.title')->get() }} | {{ Lang::line('installer::general.step_2.title')->get() }}
@endsection

@section('scripts')
<script>
	$(document).ready(function() {

		Validate.setup($("#update-form"));

	});
</script>
@endsection

@section('navigation')
	<h1>{{ Lang::line('installer::update.step_2.title') }}</h1>
	<p class="step">{{ Lang::line('installer::update.step_2.tagline') }}</p>
	<div class="breadcrumbs">
		<ul class="nav">
			<li><span>{{ Lang::line('installer::update.step_1.step') }}</span> {{ Lang::line('installer::update.step_1.step_description') }}</li>
			<li class="active"><span>{{ Lang::line('installer::update.step_2.step') }}</span> {{ Lang::line('installer::update.step_2.step_description') }}</li>
		</ul>
	</div>
@endsection

@section('content')
<section id="updates">
	<header>
		<h2>{{ Lang::line('installer::update.step_2.description') }}</h2>
	</header>
	<hr>
	<div class="container-fluid">
		<div class="row-fluid">
			<div class="span12">

				<pre style="word-break: break-word;">{{ $license }}</pre>

				<p class="agree">
					<a href="{{ URL::base() }}" class="btn btn-large">I Agree, Continue to the Home Page</a>
				</p>

			</div>
		</div>
	</div>
</section>
@endsection
