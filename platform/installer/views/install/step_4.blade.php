@layout('installer::template')

@section('title')
{{ Lang::line('installer::install.title')->get() }} | {{ Lang::line('installer::general.step_4.title')->get() }}
@endsection

@section('navigation')
	<h1>{{ Lang::line('installer::install.step_4.title') }}</h1>
	<p class="step">{{ Lang::line('installer::install.step_4.tagline') }}</p>
	<div class="breadcrumbs">
		<ul class="nav">
			<ul class="nav">
			<li><span>{{ Lang::line('installer::install.step_1.step') }}</span> {{ Lang::line('installer::install.step_1.step_description') }}</li>
			<li><span>{{ Lang::line('installer::install.step_2.step') }}</span> {{ Lang::line('installer::install.step_2.step_description') }}</li>
			<li><span>{{ Lang::line('installer::install.step_3.step') }}</span> {{ Lang::line('installer::install.step_3.step_description') }}</li>
			<li class="active"><span>{{ Lang::line('installer::install.step_4.step') }}</span> {{ Lang::line('installer::install.step_4.step_description') }}</li>
		</ul>
	</div>
@endsection

@section('content')

<section id="checks">
	<header>
		<h2>{{ Lang::line('installer::install.step_4.description') }}</h2>
		<p>{{ Lang::line('installer::install.step_4.licence') }}</p>
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
