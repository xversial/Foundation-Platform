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

<div class="jumbotron">

	<div class="container">

		<div class="text-center">

			<img src="{{ Asset::getUrl('img/brand-logo.png') }}" alt="Platform 2 Logo" />

			@content('synopsis')

		</div>

	</div>

</div>

<div class="row">

	<div class="col-lg-4">@content('packages')</div>

	<div class="col-lg-4">@content('extensions')</div>

	<div class="col-lg-4">@content('themes')</div>

</div>

@stop
