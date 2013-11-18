@if ($errors->any())

	<div data-alert class="alert-box">

		{{{ trans('general.error') }}}

		@if ($message = $errors->first(0, ':message'))
			{{ $message }}
		@else
			Please check the form below for errors
		@endif

		<a href="#" class="close">&times;</a>
	</div>

@endif

@if ($notifications = Session::get('notifications') and $notifications->has('success'))

	<div data-alert class="alert-box">

			{{{ trans('general.success') }}}

			@foreach ($notifications->get('success') as $message)
			{{ $message }}
			@endforeach

		<a href="#" class="close">&times;</a>
	</div>

@endif

@if ($notifications = Session::get('notifications') and $notifications->has('error'))

	<div data-alert class="alert-box">

		{{{ trans('general.error') }}}

		@foreach ($notifications->get('error') as $message)
		{{ $message }}
		@endforeach

		<a href="#" class="close">&times;</a>
	</div>

@endif
