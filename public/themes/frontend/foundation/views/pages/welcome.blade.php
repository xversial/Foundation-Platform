@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{{ $page->meta_title }}}
@stop

{{-- Meta description --}}
@section('meta-description')
{{{ $page->meta_description }}}
@stop

{{-- Page content --}}
@section('content')

<div class="row">

	<div class="large-12 columns">

		<div class="panel text-center">

			<h1>Platform RC3</h1>

			<h4 class="subheader">@content('synopsis')</h2>

		</div>

	</div>

</div>

<div class="row text-center">

	<div class="large-4 columns">@content('packages')</div>

	<div class="large-4 columns">@content('extensions')</div>

	<div class="large-4 columns">@content('themes')</div>

</div>

@stop
