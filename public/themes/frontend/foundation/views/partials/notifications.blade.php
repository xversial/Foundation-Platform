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

@if ($message = Session::get('success'))

	<div data-alert class="alert-box">

		{{{ trans('general.success') }}}

		{{ $message }}

		<a href="#" class="close">&times;</a>

	</div>

@endif
