@extends('templates/default')

@section('content')

<div class="introduction hero-unit">

	<center><img src="{{ Asset::getUrl('img/brand-logo.png') }}" alt="Platform 2 Logo" /></center>

	@content('hero')

</div>

<div class="row">

	<div class="span4">
		@content('develop')
	</div>

	<div class="span4">
		@content('design')
	</div>

	<div class="span4">
		@content('extend')
	</div>

</div>

<div class="row">

	<div class="span4">

	</div>

	<div class="span4">

	</div>

	<div class="span4">

	</div>

</div>

@stop
