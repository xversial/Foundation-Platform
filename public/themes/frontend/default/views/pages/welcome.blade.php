@extends('templates/default')

@section('content')

<h1>This is the default template</h1>

<div class="well">
	@content('welcome')
</div>

<h3>Now, back to the page</h3>

<p>It's located at <code>pages/welcome.blade.php</code> of your theme.</p>

<a href="{{ URL::toAdmin('/') }}" class="btn">Admin</a>

@stop
