@extends('templates/default')

@section('content')

<div class="introduction hero-unit">

	<center><img src="{{ Asset::getUrl('img/brand-logo.png') }}" alt="Platform 2 Logo" /></center>
	<br>
	@content('synopsis')

</div>

<div class="row">

	<div class="span4">
		@content('api')
	</div>

	<div class="span4">
		@content('sentry')
	</div>

	<div class="span4">
		@content('data-grid')
	</div>

</div>

<div class="row">

	<div class="span4">
		@content('nested-sets')
	</div>

	<div class="span4">
		@content('themes')
	</div>

	<div class="span4">
		@content('extensions')
	</div>

</div>

@stop
