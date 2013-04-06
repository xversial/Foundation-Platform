@if ($errors->any())
<div class="alert alert-error alert-block">
	<button type="button" class="close" data-dismiss="alert">&times;</button>
	<h4>Error</h4>
	@if ($message = $errors->first(0, ':message'))
	{{ $message }}
	@else
	Please check the form below for errors
	@endif
</div>
@endif

@if ($messages = Session::get('messages') and $messages->has('success'))
<div class="alert alert-success alert-block">
	<button type="button" class="close" data-dismiss="alert">&times;</button>
	<h4>Success</h4>
	@foreach ($messages->get('success') as $message)
	{{ $message }}
	@endforeach
</div>
@endif

@if ($messages = Session::get('messages') and $messages->has('error'))
<div class="alert alert-error alert-block">
	<button type="button" class="close" data-dismiss="alert">&times;</button>
	<h4>Error</h4>
	@foreach ($messages->get('error') as $message)
	{{ $message }}
	@endforeach
</div>
@endif
