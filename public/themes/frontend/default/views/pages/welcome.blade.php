@extends('templates/default')

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
<div class="introduction hero-unit">

	<img src="{{ Asset::getUrl('img/brand-logo.png') }}" alt="Platform 2 Logo" />

	@content('synopsis')

</div>

<div class="featurettes row">
	<div class="span4">@content('packages')</div>
	<div class="span4">@content('extensions')</div>
	<div class="span4">@content('themes')</div>
</div>
@stop
