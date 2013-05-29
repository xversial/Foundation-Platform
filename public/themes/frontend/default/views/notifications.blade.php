@if ($errors->any())
<div class="notification alert alert-error alert-block">
	<button type="button" class="close" data-dismiss="alert">&times;</button>
	<h4>Error</h4>
	@if ($message = $errors->first(0, ':message'))
	{{ $message }}
	@else
	Please check the form below for errors
	@endif
</div>
@endif

@if ($notifications = Session::get('notifications') and $notifications->has('success'))
<div class="notification alert alert-success alert-block">
	<button type="button" class="close" data-dismiss="alert">&times;</button>
	<h4>Success</h4>
	@foreach ($notifications->get('success') as $message)
	{{ $message }}
	@endforeach
</div>
@endif

@if ($notifications = Session::get('notifications') and $notifications->has('error'))
<div class="notification alert alert-error alert-block">
	<button type="button" class="close" data-dismiss="alert">&times;</button>
	<h4>Error</h4>
	@foreach ($notifications->get('error') as $message)
	{{ $message }}
	@endforeach
</div>
@endif
