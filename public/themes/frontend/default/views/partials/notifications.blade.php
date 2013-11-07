@if ($errors->any())
<div class="alert alert-danger alert-block">
	<button type="button" class="close" data-dismiss="alert"><i class="icon-collapse-alt"></i></button>
	<strong>{{{ trans('general.error') }}}</strong>

	@if ($message = $errors->first(0, ':message'))
		{{ $message }}
	@else
		Please check the form below for errors
	@endif
</div>
@endif

@if ($notifications = Session::get('notifications') and $notifications->has('success'))
<div class="alert alert-success alert-block">
	<button type="button" class="close" data-dismiss="alert"><i class="icon-collapse-alt"></i></button>
	<strong>{{{ trans('general.success') }}}</strong>

	@foreach ($notifications->get('success') as $message)
	{{ $message }}
	@endforeach
</div>
@endif

@if ($notifications = Session::get('notifications') and $notifications->has('error'))
<div class="alert alert-danger alert-block">
	<button type="button" class="close" data-dismiss="alert"><i class="icon-collapse-alt"></i></button>
	<strong>{{{ trans('general.error') }}}</strong>

	@foreach ($notifications->get('error') as $message)
	{{ $message }}
	@endforeach
</div>
@endif
