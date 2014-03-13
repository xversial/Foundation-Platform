@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{{ $page->meta_title }}} ::
@parent
@stop

{{-- Meta description --}}
@section('meta-description')
{{{ $page->meta_description }}}
@stop

{{-- Page content --}}
@section('content')

<div class="jumbotron">

	<div class="text-center">

		<h1>Platform RC3</h1>

		@content('synopsis')

	</div>

</div>

<div class="row text-center">

	<div class="col-lg-4">@content('packages')</div>

	<div class="col-lg-4">@content('extensions')</div>

	<div class="col-lg-4">@content('themes')</div>

</div>

@stop
