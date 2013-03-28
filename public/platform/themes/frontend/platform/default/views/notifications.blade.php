@if ($errors->any())
<div class="alert alert-error alert-block">
	<button type="button" class="close" data-dismiss="alert">&times;</button>
	<h4>Error</h4>
	Please check the form below for errors
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

@if ($messages = Session::get('messages') and $messages->has('warning'))
<div class="alert alert-warning alert-block">
	<button type="button" class="close" data-dismiss="alert">&times;</button>
	<h4>Warning</h4>
	@foreach ($messages->get('warning') as $message)
	{{ $message }}
	@endforeach
</div>
@endif

@if ($messages = Session::get('messages') and $messages->has('info'))
<div class="alert alert-info alert-block">
	<button type="button" class="close" data-dismiss="alert">&times;</button>
	<h4>Info</h4>
	@foreach ($messages->get('info') as $message)
	{{ $message }}
	@endforeach
</div>
@endif
